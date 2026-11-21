<?php


declare(strict_types=1);

// ini_set('display_errors', '0');
// ini_set('display_startup_errors', '0');
// error_reporting(0);
if (!ob_get_level()) {
  ob_start();
}
if (session_status() !== PHP_SESSION_ACTIVE) {
  @session_start();
}

// require_once(__DIR__ . '/../../includes/connect.php');
include('../../config/db_config.php');


$DSC_SAAS_BASE = 'https://dsc.kaprirahul.com';
$DSC_API_KEY   = 'dsc_0pbj_Z9CZzLvmru_yHy50FP8xEMBD79FE4YSL8gpgUU';
$CURL_TIMEOUT  = 60;
$PDFJS_SRC     = '/adminpanel/assets/pdfjs/pdf.min.js';
$PDFJS_WORKER  = '/adminpanel/assets/pdfjs/pdf.worker.min.js';
$DSCCSS     = '/adminpanel/assets/dsc.css';
$STAMP_ENABLED = true;

$AUTOLOAD = __DIR__ . '/vendor/autoload.php';
if (is_file($AUTOLOAD)) {
  require $AUTOLOAD;
}

use setasign\Fpdi\TcpdfFpdi;

function json_out(array $data, int $code = 200): void
{
  while (ob_get_level() > 0) {
    @ob_end_clean();
  }
  http_response_code($code);
  header('Content-Type: application/json; charset=utf-8');
  header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
  header('Pragma: no-cache');
  echo json_encode($data, JSON_UNESCAPED_SLASHES);
  exit;
}

function curl_request(string $method, string $url, array $headers = [], $body = null, bool $returnHeaders = false, int $timeout = 60)
{
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
  curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
  if ($returnHeaders) curl_setopt($ch, CURLOPT_HEADER, true);
  if (!empty($headers)) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  if ($body !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
  $resp = curl_exec($ch);
  $err  = curl_error($ch);
  $info = curl_getinfo($ch);
  curl_close($ch);
  return [$resp, $err, $info];
}

function dsc_headers(string $apiKey): array
{
  return ['Authorization: Bearer ' . $apiKey];
}
function dsc_url(string $base, string $path): string
{
  return rtrim($base, '/') . $path;
}
function rand_id(int $len = 32): string
{
  $bytes = random_bytes((int)ceil($len / 2));
  return substr(bin2hex($bytes), 0, $len);
}
function get_preview_store(): array
{
  if (!isset($_SESSION['dsc_preview_store']) || !is_array($_SESSION['dsc_preview_store'])) $_SESSION['dsc_preview_store'] = [];
  return $_SESSION['dsc_preview_store'];
}
function set_preview_store(array $store): void
{
  $_SESSION['dsc_preview_store'] = $store;
}
function normalize_preview_path(string $path): string
{
  $tmp = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR);
  if (strpos($path, $tmp) !== 0) return '';
  return $path;
}
function get_job_cache(): array
{
  if (!isset($_SESSION['dsc_job_cache']) || !is_array($_SESSION['dsc_job_cache'])) $_SESSION['dsc_job_cache'] = [];
  return $_SESSION['dsc_job_cache'];
}
function set_job_cache(array $cache): void
{
  $_SESSION['dsc_job_cache'] = $cache;
}
function safe_str($v): string
{
  if ($v === null) return '';
  if (is_string($v)) return $v;
  if (is_numeric($v)) return (string)$v;
  return '';
}
function extract_cn_from_subject_dn(string $dn): string
{
  $dn = trim($dn);
  if ($dn === '') return '';
  if (preg_match('/(?:^|,)\s*CN\s*=\s*([^,]+)/i', $dn, $m)) return trim($m[1]);
  if (preg_match('/^CN\s*=\s*([^,]+)/i', $dn, $m2)) return trim($m2[1]);
  return '';
}
function clamp_ascii(string $s, int $maxLen = 300): string
{
  $s = preg_replace('/[^\P{C}\n\r\t]/u', '', $s);
  $s = trim((string)$s);
  if ($maxLen > 0 && strlen($s) > $maxLen) $s = substr($s, 0, $maxLen);
  return $s;
}

function stamp_box_on_pdf(string $inPdf, string $outPdf, int $page, float $llx, float $lly, float $urx, float $ury, string $line1, string $line2, string $line3): array
{
  try {
    if (!class_exists('setasign\\Fpdi\\TcpdfFpdi')) {
      return ['ok' => false, 'error' => 'FPDI/TCPDF not installed.'];
    }
    if ($page < 1) $page = 1;
    if ($urx <= $llx || $ury <= $lly) return ['ok' => false, 'error' => 'Invalid stamp coords'];
    $pdf = new \setasign\Fpdi\TcpdfFpdi('P', 'pt');
    $pdf->SetAutoPageBreak(false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $ratio = 1.15;
    $pdf->setCellHeightRatio($ratio);
    $pdfSource = $inPdf;
    $qpdfTmp = null;
    $pdfHeader = file_get_contents($inPdf, false, null, 0, 8);
    $pdfVersion = (float)substr($pdfHeader, 5, 3);
    if ($pdfVersion >= 1.5) {
      $qpdfTmp = sys_get_temp_dir() . '/dsc_qpdf_' . rand_id(12) . '.pdf';
      $qpdfCmd = 'qpdf --stream-data=uncompress ' . escapeshellarg($inPdf) . ' ' . escapeshellarg($qpdfTmp) . ' 2>&1';
      exec($qpdfCmd, $qpdfOut, $qpdfRet);
      if ($qpdfRet === 0 && is_file($qpdfTmp) && filesize($qpdfTmp) > 100) $pdfSource = $qpdfTmp;
    }
    $pageCount = $pdf->setSourceFile($pdfSource);
    for ($i = 1; $i <= $pageCount; $i++) {
      $tplId = $pdf->importPage($i);
      $size  = $pdf->getTemplateSize($tplId);
      $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
      $pdf->AddPage($orientation, [$size['width'], $size['height']]);
      $pdf->useTemplate($tplId);
      if ($i === $page) {
        $pageW = (float)$size['width'];
        $pageH = (float)$size['height'];
        $x = (float)$llx;
        $y = (float)($pageH - (float)$ury);
        $w = (float)($urx - $llx);
        $h = (float)($ury - $lly);
        if ($w < 10) $w = 10;
        if ($h < 10) $h = 10;
        if ($x < 0) $x = 0;
        if ($y < 0) $y = 0;
        if ($x + $w > $pageW) $x = max(0.0, $pageW - $w);
        if ($y + $h > $pageH) $y = max(0.0, $pageH - $h);
        $pdf->SetLineWidth(1.2);
        $pdf->SetDrawColor(16, 124, 65);
        $pdf->SetFillColor(219, 246, 229);
        $pdf->Rect($x, $y, $w, $h, 'DF');
        $padding = 9.0;
        $tx = $x + $padding;
        $ty = $y + $padding;
        $availW = max(30.0, $w - 2 * $padding);
        $availH = max(20.0, $h - 2 * $padding);
        $t1 = trim($line1);
        $t2 = trim($line2);
        $t3 = trim($line3);
        $maxHeader = 12.0;
        $minHeader = 8.0;
        $maxName = 12.0;
        $minName = 8.0;
        $maxMeta = 10.0;
        $minMeta = 7.0;
        $scale = 1.0;
        $calc = function (float $scale) use ($pdf, $availW, $t1, $t2, $t3, $maxHeader, $minHeader, $maxName, $minName, $maxMeta, $minMeta, $ratio): array {
          $headerFont = max($minHeader, min($maxHeader, $maxHeader * $scale));
          $nameFont = max($minName, min($maxName, $maxName * $scale));
          $metaFont = max($minMeta, min($maxMeta, $maxMeta * $scale));
          $gap = 2.0;
          $pdf->SetFont('helvetica', 'B', $headerFont);
          $h1 = $pdf->getStringHeight($availW, $t1, false, true, '', $ratio);
          $pdf->SetFont('helvetica', 'B', $nameFont);
          $h2 = $pdf->getStringHeight($availW, $t2, false, true, '', $ratio);
          $pdf->SetFont('helvetica', '', $metaFont);
          $h3 = $pdf->getStringHeight($availW, $t3, false, true, '', $ratio);
          $needH = $h1 + $gap + $h2 + $gap + $h3;
          $lh1 = $headerFont * $ratio;
          $lh2 = $nameFont * $ratio;
          $lh3 = $metaFont * $ratio;
          return [$needH, $headerFont, $nameFont, $metaFont, $h1, $h2, $h3, $gap, $lh1, $lh2, $lh3];
        };
        for ($k = 0; $k < 30; $k++) {
          [$needH] = $calc($scale);
          if ($needH <= $availH) break;
          $scale -= 0.04;
          if ($scale < 0.55) {
            $scale = 0.55;
            break;
          }
        }
        [$needH, $headerFont, $nameFont, $metaFont, $h1, $h2, $h3, $gap, $lh1, $lh2, $lh3] = $calc($scale);
        $startY = $ty + max(0.0, ($availH - $needH) / 2.0);
        $maxStartY = ($ty + $availH) - $needH;
        if ($startY > $maxStartY) $startY = $maxStartY;
        if ($startY < $ty) $startY = $ty;
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', $headerFont);
        $pdf->SetXY($tx, $startY);
        $pdf->MultiCell($availW, $lh1, $t1, 0, 'L', false, 1, $tx, $startY);
        $y2 = $pdf->GetY() + $gap;
        $pdf->SetFont('helvetica', 'B', $nameFont);
        $pdf->SetXY($tx, $y2);
        $pdf->MultiCell($availW, $lh2, $t2, 0, 'L', false, 1, $tx, $y2);
        $y3 = $pdf->GetY() + $gap;
        $pdf->SetFont('helvetica', '', $metaFont);
        $pdf->SetXY($tx, $y3);
        $pdf->MultiCell($availW, $lh3, $t3, 0, 'L', false, 1, $tx, $y3);
      }
    }
    $pdf->Output($outPdf, 'F');
    if ($qpdfTmp && is_file($qpdfTmp)) @unlink($qpdfTmp);
    if (!is_file($outPdf) || filesize($outPdf) < 100) return ['ok' => false, 'error' => 'Stamped PDF not created'];
    return ['ok' => true, 'out' => $outPdf];
  } catch (\Throwable $e) {
    return ['ok' => false, 'error' => 'Stamp failed: ' . $e->getMessage()];
  }
}

$action = $_POST['action'] ?? $_GET['action'] ?? null;

if ($action) {
  if ($action === 'upload_preview') {
    if (empty($_FILES['pdf']['tmp_name'])) json_out(['ok' => false, 'error' => 'file_required'], 400);
    $tmp  = $_FILES['pdf']['tmp_name'];
    $name = $_FILES['pdf']['name'] ?? 'document.pdf';
    $bytes = @file_get_contents($tmp);
    if ($bytes === false || strlen($bytes) < 10) json_out(['ok' => false, 'error' => 'file_read_failed'], 400);
    if (substr($bytes, 0, 5) !== '%PDF-') json_out(['ok' => false, 'error' => 'not_a_pdf'], 400);
    $id = rand_id(24);
    $dst = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . "dsc_preview_{$id}.pdf";
    if (@move_uploaded_file($tmp, $dst) !== true) {
      if (@file_put_contents($dst, $bytes) === false) json_out(['ok' => false, 'error' => 'save_failed'], 500);
    }
    $store = get_preview_store();
    $store[$id] = ['path' => $dst, 'name' => $name, 'ts' => time()];
    $now = time();
    foreach ($store as $k => $v) {
      $ts = (int)($v['ts'] ?? 0);
      if ($ts && ($now - $ts) > 21600) {
        $p = normalize_preview_path((string)($v['path'] ?? ''));
        if ($p && is_file($p)) @unlink($p);
        unset($store[$k]);
      }
    }
    set_preview_store($store);
    json_out(['ok' => true, 'preview_id' => $id, 'file_name' => $name, 'size_bytes' => strlen($bytes), 'preview_url' => (string)($_SERVER['PHP_SELF'] ?? 'index.php') . '?action=preview_pdf&id=' . rawurlencode($id)]);
  }

  if ($action === 'preview_pdf') {
    while (ob_get_level() > 0) {
      @ob_end_clean();
    }
    $id = (string)($_GET['id'] ?? '');
    if (!$id) {
      http_response_code(400);
      header('Content-Type:text/plain; charset=utf-8');
      echo "missing_id";
      exit;
    }
    $store = get_preview_store();
    if (!isset($store[$id])) {
      http_response_code(404);
      header('Content-Type:text/plain; charset=utf-8');
      echo "not_found";
      exit;
    }
    $path = normalize_preview_path((string)($store[$id]['path'] ?? ''));
    if (!$path || !is_file($path)) {
      http_response_code(404);
      header('Content-Type:text/plain; charset=utf-8');
      echo "missing_file";
      exit;
    }
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Content-Type: application/pdf');
    header('Content-Length: ' . (string)filesize($path));
    header('Content-Disposition: inline; filename="preview.pdf"');
    readfile($path);
    exit;
  }

  if ($DSC_API_KEY === 'REPLACE_WITH_CLIENT_API_KEY' || strlen($DSC_API_KEY) < 12) {
    json_out(['ok' => false, 'error' => 'server_not_configured_api_key'], 500);
  }

  if ($action === 'health') {
    $url = dsc_url($DSC_SAAS_BASE, '/v1/health');
    [$resp, $err, $info] = curl_request('GET', $url, [], null, false, $GLOBALS['CURL_TIMEOUT']);
    if ($err) json_out(['ok' => false, 'error' => 'curl_error', 'details' => $err], 500);
    $json = json_decode((string)$resp, true);
    if (!is_array($json)) json_out(['ok' => false, 'error' => 'invalid_json', 'raw' => $resp], 500);
    json_out(['ok' => true, 'upstream' => $json, 'http_code' => $info['http_code'] ?? null]);
  }

  if ($action === 'create_job_upload') {
    $previewId = trim((string)($_POST['preview_id'] ?? ''));
    $tmp = '';
    $name = 'document.pdf';
    if ($previewId !== '') {
      $store = get_preview_store();
      if (!isset($store[$previewId])) json_out(['ok' => false, 'error' => 'invalid_preview_id'], 400);
      $path = normalize_preview_path((string)($store[$previewId]['path'] ?? ''));
      if (!$path || !is_file($path)) json_out(['ok' => false, 'error' => 'preview_file_missing'], 400);
      $tmp = $path;
      $name = (string)($store[$previewId]['name'] ?? 'document.pdf');
    } else {
      if (empty($_FILES['pdf']['tmp_name'])) json_out(['ok' => false, 'error' => 'file_required'], 400);
      $tmp = $_FILES['pdf']['tmp_name'];
      $name = $_FILES['pdf']['name'] ?? 'document.pdf';
      $bytes = file_get_contents($tmp);
      if ($bytes === false || strlen($bytes) < 10) json_out(['ok' => false, 'error' => 'file_read_failed'], 400);
      if (substr($bytes, 0, 5) !== '%PDF-') json_out(['ok' => false, 'error' => 'not_a_pdf'], 400);
    }
    $vsPage = (int)($_POST['vs_page'] ?? 1);
    $vsX = (int)($_POST['vs_x'] ?? 50);
    $vsY = (int)($_POST['vs_y'] ?? 50);
    $vsW = (int)($_POST['vs_w'] ?? 200);
    $vsH = (int)($_POST['vs_h'] ?? 60);
    $llx = max(0, $vsX);
    $lly = max(0, $vsY);
    $urx = max(0, $vsX + max(1, $vsW));
    $ury = max(0, $vsY + max(1, $vsH));
    $signature_reason = trim((string)($_POST['signature_reason'] ?? 'Approved'));
    $signature_location = trim((string)($_POST['signature_location'] ?? ''));
    $portal_user_name = trim((string)($_POST['portal_user_name'] ?? ''));

    $signing = ['signature_reason' => $signature_reason, 'portal_user_name' => $portal_user_name, 'signature_location' => $signature_location, 'visible_signature' => ['visible' => true, 'page' => max(1, $vsPage), 'llx' => $llx, 'lly' => $lly, 'urx' => $urx, 'ury' => $ury]];
    $requester = ['portal_user_id' => trim((string)($_POST['portal_user_id'] ?? 'OFFICER_1')), 'portal_user_name' => trim((string)($_POST['portal_user_name'] ?? 'Officer')), 'portal_dept' => trim((string)($_POST['portal_dept'] ?? ''))];
    $metadata = ['portal_ref_no' => trim((string)($_POST['portal_ref_no'] ?? ''))];
    $preferredNodeId = trim((string)($_POST['preferred_node_id'] ?? ''));
    $postFields = ['file' => new CURLFile($tmp, 'application/pdf', $name), 'signing' => json_encode($signing, JSON_UNESCAPED_SLASHES), 'requester' => json_encode($requester, JSON_UNESCAPED_SLASHES), 'metadata' => json_encode($metadata, JSON_UNESCAPED_SLASHES)];
    if ($preferredNodeId !== '') $postFields['preferred_node_id'] = $preferredNodeId;
    $url = dsc_url($DSC_SAAS_BASE, '/v1/sign-jobs/upload');
    $headers = dsc_headers($DSC_API_KEY);
    [$resp, $err, $info] = curl_request('POST', $url, $headers, $postFields, false, $GLOBALS['CURL_TIMEOUT']);
    if ($err) json_out(['ok' => false, 'error' => 'curl_error', 'details' => $err], 500);
    $json = json_decode((string)$resp, true);
    if (!is_array($json)) json_out(['ok' => false, 'error' => 'invalid_json', 'raw' => $resp], 500);
    $jobId = safe_str($json['job_id'] ?? '');
    if (strlen($jobId) === 36) {
      $cache = get_job_cache();
      $cache[$jobId] = array_merge($cache[$jobId] ?? [], ['vs' => ['page' => max(1, $vsPage), 'llx' => $llx, 'lly' => $lly, 'urx' => $urx, 'ury' => $ury], 'reason' => $signature_reason, 'location' => $signature_location, 'ts_created' => time()]);
      set_job_cache($cache);
    }
    $uploadDir = __DIR__ . '/uploads/unsigned_docs/';

    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $uniqueName = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $name);
    $finalPath  = $uploadDir . $uniqueName;

    if (!copy($tmp, $finalPath)) {
      json_out(['ok' => false, 'error' => 'file_save_failed'], 500);
    }

    $districtId = $_SESSION['district_id'];
    $portal_user_id   = $_POST['portal_user_id'] ?? '';
    $dsc_type = $_GET['dsc_type'] ?? '1';
    $portal_user_name = $_POST['portal_user_name'] ?? '';
    $portal_dept      = $_POST['portal_dept'] ?? '';
    $portal_ref_no    = $_POST['portal_ref_no'] ?? '';
    $preferred_node_id = $_POST['preferred_node_id'] ?? '';
    $stmt = $conn->prepare("INSERT INTO dsc_sign_jobs 
                  (district_id,job_id,preview_id,portal_user_id,portal_user_name,portal_dept,portal_ref_no,
                  signature_reason,signature_location,vs_page,llx,lly,urx,ury,
                  pdf_name,pdf_path,preferred_node_id,type)
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param(
      "ssssssssiiiiisssss",
      $districtId,
      $jobId,
      $previewId,
      $portal_user_id,
      $portal_user_name,
      $portal_dept,
      $portal_ref_no,
      $signature_reason,
      $signature_location,
      $vsPage,
      $llx,
      $lly,
      $urx,
      $ury,
      $uniqueName,
      $finalPath,
      $preferredNodeId,
      $dsc_type
    );
    $stmt->execute();
    json_out(['ok' => true, 'http_code' => $info['http_code'] ?? null, 'upstream' => $json]);
  }

  if ($action === 'job_status') {
    $jobId = trim((string)($_POST['job_id'] ?? ''));
    if (strlen($jobId) !== 36) json_out(['ok' => false, 'error' => 'invalid_job_id'], 400);
    $url = dsc_url($DSC_SAAS_BASE, '/v1/sign-jobs/' . rawurlencode($jobId));
    $headers = array_merge(dsc_headers($DSC_API_KEY), ['Accept: application/json']);
    [$resp, $err, $info] = curl_request('GET', $url, $headers, null, false, $GLOBALS['CURL_TIMEOUT']);
    if ($err) json_out(['ok' => false, 'error' => 'curl_error', 'details' => $err], 500);
    $json = json_decode((string)$resp, true);
    if (!is_array($json)) json_out(['ok' => false, 'error' => 'invalid_json', 'raw' => $resp], 500);
    $job = $json['job'] ?? $json;
    $status = strtolower(safe_str($job['status'] ?? ''));
    if ($status === 'signed') {
      $subjectDn = safe_str($job['signer_cert']['subject_dn'] ?? '');
      $cn = extract_cn_from_subject_dn($subjectDn);
      $signedAt = safe_str($job['signed_at'] ?? '') ?: safe_str($job['signedAt'] ?? '') ?: safe_str($job['completed_at'] ?? '') ?: safe_str($job['completedAt'] ?? '') ?: safe_str($job['updated_at'] ?? '');
      $cache = get_job_cache();
      $cache[$jobId] = array_merge($cache[$jobId] ?? [], ['signer' => ($cn !== '' ? $cn : $subjectDn), 'signed_at' => $signedAt, 'ts_signed_cached' => time()]);
      set_job_cache($cache);
    }
    json_out(['ok' => true, 'http_code' => $info['http_code'] ?? null, 'upstream' => $json]);
  }

  if ($action === 'download_pdf') {
    while (ob_get_level() > 0) {
      @ob_end_clean();
    }
    $jobId = trim((string)($_GET['job_id'] ?? ''));
    if (strlen($jobId) !== 36) {
      http_response_code(400);
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['ok' => false, 'error' => 'invalid_job_id'], JSON_UNESCAPED_SLASHES);
      exit;
    }
    $browserLocal = clamp_ascii((string)($_GET['local_time'] ?? ''), 120);
    $browserTz = clamp_ascii((string)($_GET['tz'] ?? ''), 80);
    $jobUrl = dsc_url($DSC_SAAS_BASE, '/v1/sign-jobs/' . rawurlencode($jobId));
    $headers = array_merge(dsc_headers($DSC_API_KEY), ['Accept: application/json']);
    [$jobResp, $jobErr, $jobInfo] = curl_request('GET', $jobUrl, $headers, null, false, $GLOBALS['CURL_TIMEOUT']);
    $jobJson = null;
    $job = null;
    if (!$jobErr) {
      $jobJson = json_decode((string)$jobResp, true);
      if (is_array($jobJson)) $job = $jobJson['job'] ?? $jobJson;
    }
    $status = strtolower(safe_str($job['status'] ?? ''));
    $isSigned = ($status === 'signed');
    $subjectDn = safe_str($job['signer_cert']['subject_dn'] ?? '');
    $cn = extract_cn_from_subject_dn($subjectDn);
    $signerCn = ($cn !== '' ? $cn : '');
    $reason = safe_str($job['signing']['signature_reason'] ?? '');
    $location = safe_str($job['signing']['signature_location'] ?? '');
    $portal_user_name = safe_str($job['requester']['portal_user_name'] ?? '');

    $pdfUrl = dsc_url($DSC_SAAS_BASE, '/v1/sign-jobs/' . rawurlencode($jobId) . '/result/pdf');
    [$resp, $err, $info] = curl_request('GET', $pdfUrl, dsc_headers($DSC_API_KEY), null, false, $GLOBALS['CURL_TIMEOUT']);
    if ($err) {
      http_response_code(500);
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['ok' => false, 'error' => 'curl_error', 'details' => $err], JSON_UNESCAPED_SLASHES);
      exit;
    }
    $code = (int)($info['http_code'] ?? 0);
    if ($code !== 200 || !is_string($resp) || strlen($resp) < 100) {
      http_response_code($code ?: 502);
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(['ok' => false, 'error' => 'upstream_non_200', 'http_code' => $code, 'body' => mb_substr((string)$resp, 0, 2000)], JSON_UNESCAPED_SLASHES);
      exit;
    }
    $in = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'dsc_signed_in_' . $jobId . '_' . rand_id(8) . '.pdf';
    @file_put_contents($in, $resp);
    $finalPath = $in;
    $cache = get_job_cache();
    $c = $cache[$jobId] ?? [];
    $vs = (isset($c['vs']) && is_array($c['vs'])) ? $c['vs'] : null;
    if (!$vs) {
      $rawVs = $job['signing']['visible_signature'] ?? null;
      if (is_string($rawVs) && $rawVs !== '') {
        $decoded = json_decode($rawVs, true);
        if (is_array($decoded) && !empty($decoded['visible'])) {
          $vs = ['page' => (int)($decoded['page'] ?? 1), 'llx' => (float)($decoded['llx'] ?? 0), 'lly' => (float)($decoded['lly'] ?? 0), 'urx' => (float)($decoded['urx'] ?? 0), 'ury' => (float)($decoded['ury'] ?? 0)];
        }
      }
    }
    if (!empty($GLOBALS['STAMP_ENABLED']) && $vs && is_file($in) && filesize($in) > 100) {
      $page = (int)($vs['page'] ?? 1);
      $llx = (float)($vs['llx'] ?? 0);
      $lly = (float)($vs['lly'] ?? 0);
      $urx = (float)($vs['urx'] ?? 0);
      $ury = (float)($vs['ury'] ?? 0);
      if ($urx > $llx && $ury > $lly) {
        $line1 = $isSigned ? 'DIGITALLY SIGNED BY' : 'DIGITALLY SIGNED';
        // $line2 = $isSigned ? ($signerCn !== '' ? $signerCn : '—') : '—';
        $line2 = $isSigned ? $portal_user_name : '-';

        $meta = [];
        if ($isSigned) {
          $lt = $browserLocal !== '' ? $browserLocal : '';
          if ($lt !== '') $meta[] = 'Date/Time : ' . $lt;
        }
        if ($reason !== '') $meta[] = 'Reason : ' . $reason;
        if ($location !== '') $meta[] = 'Location : ' . $location;
        $line3 = $meta ? implode(' | ', $meta) : '—';
        $out = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'dsc_signed_stamped_' . $jobId . '_' . rand_id(8) . '.pdf';
        $res = stamp_box_on_pdf($in, $out, $page, $llx, $lly, $urx, $ury, $line1, $line2, $line3);
        if (($res['ok'] ?? false) && is_file($out) && filesize($out) > 100) $finalPath = $out;
      }
    }
    $uploadDir = __DIR__ . '/uploads/signed_docs/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }
    $fileName = 'signed_' . $jobId . '_' . time() . '.pdf';
    $savePath = $uploadDir . $fileName;

    if (copy($finalPath, $savePath)) {
      $districtId = $_SESSION['district_id'];
      $stmt = $conn->prepare("UPDATE dsc_sign_jobs 
                           SET signed_pdf_name=? 
                           WHERE job_id=?");
      $stmt->bind_param("ss", $fileName, $jobId);
      $stmt->execute();
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="signed_' . $jobId . '.pdf"');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Content-Length: ' . (string)filesize($finalPath));
    readfile($finalPath);
    @unlink($in);
    if ($finalPath !== $in) @unlink($finalPath);
    exit;
  }

  if ($action === 'audit') {
    $qs = [];
    foreach (['job_id', 'event_type', 'from', 'to', 'limit', 'offset'] as $k) {
      if (!empty($_POST[$k])) $qs[$k] = (string)$_POST[$k];
    }
    $url = dsc_url($DSC_SAAS_BASE, '/v1/audit');
    if (!empty($qs)) $url .= '?' . http_build_query($qs);
    $headers = array_merge(dsc_headers($DSC_API_KEY), ['Accept: application/json']);
    [$resp, $err, $info] = curl_request('GET', $url, $headers, null, false, $GLOBALS['CURL_TIMEOUT']);
    if ($err) json_out(['ok' => false, 'error' => 'curl_error', 'details' => $err], 500);
    $json = json_decode((string)$resp, true);
    if (!is_array($json)) json_out(['ok' => false, 'error' => 'invalid_json', 'raw' => $resp], 500);
    json_out(['ok' => true, 'http_code' => $info['http_code'] ?? null, 'upstream' => $json]);
  }

  if ($action === 'event_types') {
    $url = dsc_url($DSC_SAAS_BASE, '/v1/audit/event-types');
    $headers = array_merge(dsc_headers($DSC_API_KEY), ['Accept: application/json']);
    [$resp, $err, $info] = curl_request('GET', $url, $headers, null, false, $GLOBALS['CURL_TIMEOUT']);
    if ($err) json_out(['ok' => false, 'error' => 'curl_error', 'details' => $err], 500);
    $json = json_decode((string)$resp, true);
    if (!is_array($json)) json_out(['ok' => false, 'error' => 'invalid_json', 'raw' => $resp], 500);
    json_out(['ok' => true, 'http_code' => $info['http_code'] ?? null, 'upstream' => $json]);
  }

  json_out(['ok' => false, 'error' => 'unknown_action'], 400);
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>DSC Signing</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="<?= htmlspecialchars($PDFJS_SRC, ENT_QUOTES); ?>"></script>
  <style>
    :root {
      --bg: #0d1117;
      --surface: #161b22;
      --surface2: #1c2330;
      --surface3: #21262d;
      --border: #30363d;
      --border2: #21262d;
      --text: #e6edf3;
      --text2: #8b949e;
      --text3: #6e7681;
      --accent: #1f6feb;
      --accent-soft: rgba(31, 111, 235, .12);
      --accent-glow: rgba(31, 111, 235, .35);
      --green: #3fb950;
      --green-soft: rgba(63, 185, 80, .12);
      --green-glow: rgba(63, 185, 80, .3);
      --amber: #d29922;
      --red: #f85149;
      --mono: 'IBM Plex Mono', monospace;
      --sans: 'Sora', ui-sans-serif, system-ui, sans-serif;
      --r: 12px;
      --r-sm: 8px;
      --r-lg: 16px;
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      height: 100%;
    }

    body {
      background: #fff;
      color: var(--text);
      font-family: var(--sans);
      font-size: 13px;
      line-height: 1.5;
      min-height: 100vh;
      padding: 20px;
    }

    .wrap {
      max-width: 1560px;
      margin: 0 auto;
    }

    /* ── Topbar ── */
    .topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      padding: 0 0 20px;
      border-bottom: 1px solid var(--border);
      margin-bottom: 20px;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .brand-icon {
      width: 36px;
      height: 36px;
      background: linear-gradient(135deg, var(--accent) 0%, #388bfd 100%);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 17px;
      box-shadow: 0 0 18px var(--accent-glow);
      flex-shrink: 0;
    }

    .brand-text .name {
      font-size: 15px;
      font-weight: 700;
      letter-spacing: -.2px;
      color: var(--text);
    }

    .brand-text .sub {
      font-size: 11.5px;
      color: var(--text3);
      margin-top: 1px;
      font-weight: 500;
    }

    .topbar-nav {
      display: flex;
      gap: 6px;
      align-items: center;
    }

    /* ── Buttons ── */
    .btn {
      font-family: var(--sans);
      font-size: 12.5px;
      font-weight: 600;
      padding: 7px 14px;
      border-radius: var(--r-sm);
      border: 1px solid var(--border);
      background: #2a1c5a;
      color: #fff;
      cursor: pointer;
      transition: all .15s ease;
      white-space: nowrap;
      line-height: 1;
    }

    .btn:hover {
      background: var(--surface2);
      color: var(--text);
      border-color: #484f58;
    }

    .btn:active {
      transform: scale(.97);
    }

    .btn:disabled {
      opacity: .4;
      cursor: not-allowed;
      transform: none;
    }

    .btn-primary {
      background: #2a1c5a;
      border-color: transparent;
      color: #fff;
      box-shadow: 0 0 0 0 var(--accent-glow);
      transition: all .15s ease, box-shadow .2s ease;
    }

    .btn-primary:hover {
      background: #4b3a6e;
      box-shadow: 0 0 14px var(--accent-glow);
      border-color: transparent;
      color: #fff;
    }

    .btn-blue {
      background: rgb(7, 131, 255);
      border-color: transparent;
      color: #fff;
      font-weight: 700;
    }

    .btn-blue:hover {
      background: rgba(7, 131, 255, 0.71);
      border-color: transparent;
      color: #fff;
      box-shadow: 0 0 14px var(--green-glow);
    }

    .btn-red {
      background: rgb(255, 68, 0);
      border-color: transparent;
      color: #fff;
      font-weight: 700;
    }

    .btn-red:hover {
      background: rgb(255, 117, 67);
      border-color: transparent;
      color: #fff;
      box-shadow: 0 0 14px var(--green-glow);
    }

    .btn-green {
      background: var(--green);
      border-color: transparent;
      color: #fff;
      font-weight: 700;
    }

    .btn-green:hover {
      background: #56d364;
      border-color: transparent;
      color: #fff;
      box-shadow: 0 0 14px var(--green-glow);
    }

    .btn-green:disabled {
      background: var(--surface3);
      color: var(--text3);
      border-color: var(--border);
      box-shadow: none;
    }

    .btn-ghost {
      background: transparent;
      border-color: transparent;
      color: var(--text3);
    }

    .btn-ghost:hover {
      background: var(--surface3);
      border-color: var(--border);
      color: var(--text2);
    }

    .btn-sm {
      padding: 5px 10px;
      font-size: 11.5px;
    }

    /* ── Layout ── */
    .main-grid {
      display: grid;
      grid-template-columns: 1fr 380px;
      gap: 16px;
    }

    @media (max-width: 1100px) {
      .main-grid {
        grid-template-columns: 1fr;
      }
    }

    /* ── Cards ── */
    .card {
      background: #ffa852bd;
      border: 1px solid var(--border);
      border-radius: var(--r-lg);
      overflow: hidden;
    }

    .card-header {
      padding: 12px 16px;
      border-bottom: 1px solid var(--border2);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      background: rgb(255 72 7);
    }

    .card-header-left {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .card-title {
      font-size: 13px;
      font-weight: 700;
      color: var(--text);
    }

    .card-tag {
      font-family: var(--mono);
      font-size: 10.5px;
      padding: 3px 8px;
      border-radius: 6px;
      background: var(--surface3);
      border: 1px solid var(--border);
      color: var(--text3);
    }

    .card-body {
      padding: 16px;
    }

    /* ── Form elements ── */
    .field {
      margin-bottom: 14px;
    }

    .field:last-child {
      margin-bottom: 0;
    }

    .label {
      display: block;
      font-size: 11.5px;
      font-weight: 600;
      color: var(--text2);
      margin-bottom: 6px;
      letter-spacing: .3px;
      text-transform: uppercase;
    }

    input[type=text],
    input[type=number],
    input[type=file] {
      width: 100%;
      padding: 8px 11px;
      border-radius: var(--r-sm);
      border: 1px solid var(--border);
      background: var(--surface3);
      color: var(--text);
      font-family: var(--sans);
      font-size: 13px;
      outline: none;
      transition: border-color .15s, box-shadow .15s;
    }

    input[type=text]:focus,
    input[type=number]:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px var(--accent-soft);
    }

    input[readonly] {
      color: var(--text2);
      cursor: default;
    }

    input::placeholder {
      color: var(--text3);
    }

    input[type=file] {
      padding: 6px 10px;
      cursor: pointer;
    }

    input[type=file]::file-selector-button {
      font-family: var(--sans);
      font-size: 12px;
      font-weight: 600;
      background: var(--surface2);
      border: 1px solid var(--border);
      border-radius: 6px;
      color: var(--text2);
      padding: 4px 10px;
      cursor: pointer;
      margin-right: 10px;
      transition: background .15s;
    }

    input[type=file]::file-selector-button:hover {
      background: var(--surface3);
      color: var(--text);
    }

    .help-text {
      font-size: 11.5px;
      color: var(--text3);
      margin-top: 5px;
    }

    .grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
    }

    .grid-3 {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 10px;
    }

    .grid-4 {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr;
      gap: 10px;
    }

    @media (max-width: 500px) {

      .grid-2,
      .grid-3,
      .grid-4 {
        grid-template-columns: 1fr;
      }
    }

    .sep {
      height: 1px;
      background: var(--border2);
      margin: 16px 0;
    }

    /* ── Upload drop zone ── */
    .drop-zone {
      border: 1.5px dashed var(--border);
      border-radius: var(--r);
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: all .2s;
      background: rgb(221 59 0 / 49%);
      position: relative;
    }

    .drop-zone:hover,
    .drop-zone.dragover {
      border-color: var(--accent);
      background: var(--accent-soft);
    }

    .drop-zone input[type=file] {
      position: absolute;
      inset: 0;
      opacity: 0;
      cursor: pointer;
      width: 100%;
      height: 100%;
    }

    .drop-icon {
      font-size: 24px;
      margin-bottom: 8px;
      display: block;
    }

    .drop-label {
      font-size: 13px;
      color: #fff;
      font-weight: 600;
    }

    .drop-hint {
      font-size: 11.5px;
      color: #fff;
      margin-top: 4px;
    }

    /* ── Step badges ── */
    .step-row {
      display: flex;
      gap: 8px;
      align-items: flex-start;
      margin-bottom: 14px;
    }

    .step-num {
      width: 22px;
      height: 22px;
      border-radius: 50%;
      background: var(--accent-soft);
      border: 1.5px solid var(--accent);
      color: var(--accent);
      font-size: 11px;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      margin-top: 1px;
    }

    .step-content {
      flex: 1;
    }

    .step-title {
      font-size: 12.5px;
      font-weight: 700;
      color: #000;
      margin-bottom: 8px;
    }

    /* ── Stage / Canvas ── */
    .stage-wrap {
      position: relative;
      border: 1px solid var(--border);
      border-radius: var(--r);
      background: #fff;
      overflow: auto;
      height: calc(100vh - 300px);
      min-height: 440px;
    }

    .stage-inner {
      padding: 12px;
      min-height: 100%;
      display: flex;
      align-items: flex-start;
      justify-content: center;
    }

    #pdfCanvas {
      display: block;
      border-radius: 6px;
      box-shadow: 0 0 40px rgba(0, 0, 0, .6);
    }

    #sigBox {
      position: absolute;
      border: 2px solid var(--green);
      background: var(--green-soft);
      box-shadow: 0 0 0 4px var(--green-glow), inset 0 0 24px rgba(63, 185, 80, .06);
      border-radius: 8px;
      pointer-events: none;
      display: none;
      overflow: hidden;
    }

    #sigLabel {
      position: absolute;
      left: 8px;
      bottom: 8px;
      font-size: 10px;
      font-weight: 700;
      line-height: 1.3;
      color: var(--text);
      background: rgba(13, 17, 23, .82);
      border: 1px solid rgba(63, 185, 80, .3);
      padding: 4px 7px;
      border-radius: 6px;
      white-space: pre-line;
      max-width: calc(100% - 16px);
      font-family: var(--mono);
      backdrop-filter: blur(4px);
    }

    /* ── Stage toolbar ── */
    .stage-toolbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 8px;
      flex-wrap: wrap;
      margin-bottom: 10px;
    }

    .stage-toolbar-left,
    .stage-toolbar-right {
      display: flex;
      gap: 6px;
      align-items: center;
      flex-wrap: wrap;
    }

    .page-info {
      font-family: var(--mono);
      font-size: 11px;
      color: #fff;
      padding: 5px 10px;
      border: 1px solid var(--border2);
      border-radius: 6px;
      background: #2a1c5a;
    }

    .preset-row {
      display: flex;
      gap: 6px;
      align-items: center;
      margin-bottom: 10px;
    }

    .preset-label {
      font-size: 13px;
      color: #000;
      font-weight: 600;
    }

    /* ── Status strip ── */
    .status-strip {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      background: var(--surface2);
      border: 1px solid var(--border);
      border-radius: var(--r);
      margin-bottom: 14px;
    }

    .status-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: var(--text3);
      flex-shrink: 0;
      transition: background .3s, box-shadow .3s;
    }

    .status-dot.ok {
      background: var(--green);
      box-shadow: 0 0 0 4px var(--green-soft);
    }

    .status-dot.warn {
      background: var(--amber);
      box-shadow: 0 0 0 4px rgba(210, 153, 34, .2);
    }

    .status-dot.bad {
      background: var(--red);
      box-shadow: 0 0 0 4px rgba(248, 81, 73, .2);
    }

    .status-label {
      font-size: 11px;
      font-weight: 600;
      color: var(--text3);
      text-transform: uppercase;
      letter-spacing: .5px;
    }

    .status-value {
      font-size: 15px;
      font-weight: 800;
      color: var(--text);
    }

    .status-right {
      margin-left: auto;
    }

    /* ── KPI chips ── */
    .kpi-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px;
      margin-bottom: 14px;
    }

    .kpi-box {
      background: var(--surface3);
      border: 1px solid var(--border2);
      border-radius: var(--r-sm);
      padding: 10px 12px;
    }

    .kpi-label {
      font-size: 10.5px;
      color: var(--text3);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .4px;
      margin-bottom: 4px;
    }

    .kpi-val {
      font-size: 12.5px;
      font-weight: 700;
      color: var(--text);
      word-break: break-word;
      font-family: var(--mono);
    }

    /* ── Code output ── */
    .out-wrap {
      background: #090d13;
      border: 1px solid var(--border2);
      border-radius: var(--r-sm);
      overflow: hidden;
    }

    .out-header {
      padding: 7px 12px;
      border-bottom: 1px solid var(--border2);
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: var(--surface3);
    }

    .out-title {
      font-family: var(--mono);
      font-size: 10.5px;
      color: var(--text3);
    }

    pre {
      padding: 12px;
      max-height: 280px;
      overflow: auto;
      font-family: var(--mono);
      font-size: 11px;
      line-height: 1.5;
      color: #7ee787;
      white-space: pre-wrap;
      word-break: break-word;
    }

    /* ── Error banner ── */
    .err-banner {
      display: none;
      padding: 10px 14px;
      background: rgba(248, 81, 73, .1);
      border: 1px solid rgba(248, 81, 73, .3);
      border-radius: var(--r-sm);
      color: #ff7b72;
      font-size: 12.5px;
      font-weight: 600;
      margin-bottom: 12px;
    }

    /* ── Collapsible sections ── */
    .collapsible {
      border: 1px solid var(--border);
      border-radius: var(--r-lg);
      overflow: hidden;
      margin-bottom: 10px;
    }

    .collapsible-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 16px;
      background: var(--surface2);
      cursor: pointer;
      user-select: none;
      transition: background .15s;
    }

    .collapsible-header:hover {
      background: var(--surface3);
    }

    .collapsible-header-left {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .collapsible-toggle {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: var(--surface3);
      border: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      color: var(--text3);
      transition: transform .2s, background .15s;
      flex-shrink: 0;
    }

    .collapsible.open .collapsible-toggle {
      transform: rotate(180deg);
      background: var(--accent-soft);
      border-color: var(--accent);
      color: var(--accent);
    }

    .collapsible-body {
      background: var(--surface);
      display: none;
      padding: 16px;
    }

    .collapsible.open .collapsible-body {
      display: block;
    }

    /* ── Bottom section ── */
    .bottom-section {
      margin-top: 16px;
    }

    .bottom-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
    }

    @media (max-width: 900px) {
      .bottom-grid {
        grid-template-columns: 1fr;
      }
    }

    /* ── Local clock ── */
    .clock-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 14px;
    }

    .clock-badge {
      font-family: var(--mono);
      font-size: 11.5px;
      padding: 6px 12px;
      border: 1px solid var(--border);
      border-radius: 6px;
      background: var(--surface3);
      color: var(--green);
      flex: 1;
    }

    /* ── Divider with label ── */
    .divider-label {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 14px 0;
    }

    .divider-label::before,
    .divider-label::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border2);
    }

    .divider-label span {
      font-size: 10.5px;
      color: var(--text3);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .5px;
      white-space: nowrap;
    }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }

    ::-webkit-scrollbar-track {
      background: transparent;
    }

    ::-webkit-scrollbar-thumb {
      background: var(--border);
      border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #484f58;
    }

    .mono {
      font-family: var(--mono);
    }
  </style>
</head>

<body>
  <div class="wrap">
    <div class="main-grid">
      <div class="card">
        <div class="card-header">
          <div class="card-header-left">
            <span class="card-title">UC PDF Preview</span>
          </div>
          <div style="display:flex;gap:6px;align-items:center;">
            <span id="pdfInfo" class="page-info">No document loaded</span>
          </div>
        </div>
        <div class="card-body">
          <div class="stage-toolbar">
            <div class="stage-toolbar-left">
              <div class="preset-label">Box size:</div>
              <button class="btn btn-sm" onclick="setBoxPreset('S')">Small</button>
              <button class="btn btn-sm" onclick="setBoxPreset('M')">Medium</button>
              <button class="btn btn-sm" onclick="setBoxPreset('L')">Large</button>
              <button class="btn btn-sm" onclick="clearBox()">Clear</button>
            </div>
            <div class="stage-toolbar-right">
              <button class="btn btn-sm" onclick="prevPage()">← Prev</button>
              <button class="btn btn-sm" onclick="nextPage()">Next →</button>
              <button class="btn btn-sm" onclick="zoomOut()">−</button>
              <button class="btn btn-sm" onclick="zoomIn()">+</button>
            </div>
          </div>

          <div class="stage-wrap" id="stage">
            <div class="stage-inner">
              <canvas id="pdfCanvas"></canvas>
            </div>
            <div id="sigBox">
              <div id="sigLabel">Digitally signed</div>
            </div>
          </div>
        </div>
      </div>
      <!-- RIGHT: Create Job -->
      <div class="card">
        <div class="card-body">
          <div class="step-row">
            <div class="step-content">
              <div class="step-title">Upload PDF</div>
              <div class="drop-zone" id="dropZone">
                <input type="file" id="pdfFile" accept="application/pdf" onchange="onFileChosen(this.files && this.files[0] ? this.files[0] : null)">
                <span class="drop-icon">📄</span>
                <div class="drop-label">Drop UC PDF </div>
                <div class="drop-hint" id="dropHint">PDF only · Max recommended 20 MB</div>
              </div>
              <div style="margin-top:10px;">
                <button id="btnUploadPreview" class="btn btn-primary" type="button" onclick="uploadAndPreview()" disabled style="width:100%;">Upload & Preview PDF</button>
              </div>
            </div>
          </div>
          <?php
          $userId = '1';
          $userName = "Test";
          $districtName = "Agra";
          ?>
          <div class="sep"></div>
          <div class="step-row">
            <div class="step-content">
              <form id="formCreate" onsubmit="return createJob(event)">
                <input type="hidden" id="preview_id" name="preview_id" value="">
                <div class="grid-2" style="margin-bottom:0px;">
                  <div class="field">
                    <input type="hidden" name="signature_reason" value="Approved">
                  </div>
                  <div class="field">
                    <input type="hidden" name="signature_location" value="<?= $districtName; ?>">
                  </div>
                </div>
                <div class="grid-3" style="margin-bottom:0px;">
                  <div class="field">
                    <input id="vs_page" type="hidden" name="vs_page" value="1" min="1">
                  </div>
                  <div class="field">
                    <input id="vs_x" type="hidden" name="vs_x" value="50" min="0">
                  </div>
                  <div class="field">
                    <input id="vs_y" type="hidden" name="vs_y" value="50" min="0">
                  </div>
                </div>
                <div class="grid-2" style="margin-bottom:10px;">
                  <div class="field">
                    <input id="vs_w" type="hidden" name="vs_w" value="200" min="1">
                  </div>
                  <div class="field">
                    <input id="vs_h" type="hidden" name="vs_h" value="60" min="1">
                  </div>
                </div>
                <div class="grid-2" style="margin-bottom:0px;">
                  <div class="field">
                    <input type="hidden" name="portal_user_id" value="<?= $userId; ?>">
                  </div>
                  <div class="field">
                    <input type="hidden" name="portal_user_name" value="<?= $userName ?? "N/A"; ?>">
                  </div>
                </div>
                <div class="step-row">
                  <div class="step-content">
                    <div id="errBox" class="err-banner"></div>
                    <div class="grid-2">
                      <button id="btnCreateJob" class="btn btn-red" type="submit" disabled style="width:100%; padding:10px;">Proceed to sign</button>
                      <div class="field">
                        <input id="jobId" class="mono" type="hidden" placeholder="auto-filled" readonly>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <button id="btnDownload" class="btn btn-blue" onclick="downloadPdf()" disabled>⬇ Download Signed UC</button>
              <button id="btnForward" class="btn btn-green" onclick="forwardSignedUC()" disabled>Forward Signed UC</button>
            </div>
          </div>
          <div class="out-wrap" style="display: none;">
            <div class="out-header">
              <span class="out-title">create_job · response</span>
              <button class="btn btn-ghost btn-sm" onclick="copyPre('outCreate')">Copy</button>
            </div>
            <pre id="outCreate">{}</pre>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-section">
      <div class="collapsible" id="secStatus" style="display: none;">
        <div class="collapsible-header" onclick="toggleCollapsible('secStatus')">
          <div class="collapsible-header-left">
            <span style="font-size:15px;">📡</span>
            <span class="card-title">Job Status &amp; Download</span>
            <span class="card-tag">GET /v1/sign-jobs/:jobId</span>
          </div>
          <div class="collapsible-toggle">▾</div>
        </div>
        <div class="collapsible-body">
          <div class="clock-row">
            <span style="font-size:11.5px;color:var(--text3);font-weight:600;white-space:nowrap;">Local Time</span>
            <input id="localClock" class="clock-badge" type="text" readonly>
            <button class="btn btn-primary btn-sm" onclick="checkStatus()">Check Status</button>
            <button class="btn btn-sm" onclick="startPolling()">Poll (3s)</button>
            <button class="btn btn-sm" onclick="stopPolling()">Stop</button>
          </div>

          <div class="status-strip">
            <div id="statusDot" class="status-dot"></div>
            <div>
              <div class="status-label">Status</div>
              <div id="statusValue" class="status-value">—</div>
            </div>
          </div>
          <div class="kpi-row">
            <div class="kpi-box">
              <div class="kpi-label">Attempts</div>
              <div id="kpiAttempts" class="kpi-val">—</div>
            </div>
            <div class="kpi-box">
              <div class="kpi-label">Assigned Node</div>
              <div id="kpiNode" class="kpi-val">—</div>
            </div>
            <div class="kpi-box">
              <div class="kpi-label">Signer (DSC CN)</div>
              <div id="kpiSigner" class="kpi-val">—</div>
            </div>
            <div class="kpi-box">
              <div class="kpi-label">Signed At (Local)</div>
              <div id="kpiSignedAtLocal" class="kpi-val">—</div>
            </div>
          </div>
          <div class="out-wrap">
            <div class="out-header">
              <span class="out-title">status · response</span>
              <button class="btn btn-ghost btn-sm" onclick="copyPre('outStatus')">Copy</button>
            </div>
            <pre id="outStatus">{}</pre>
          </div>
        </div>
      </div>
      <div class="bottom-grid" style="display: none;">
        <div class="collapsible" id="secAudit">
          <div class="collapsible-header" onclick="toggleCollapsible('secAudit')">
            <div class="collapsible-header-left">
              <span style="font-size:15px;">🧾</span>
              <span class="card-title">Audit Log</span>
              <span class="card-tag">GET /v1/audit</span>
            </div>
            <div class="collapsible-toggle">▾</div>
          </div>
          <div class="collapsible-body">
            <div style="display:flex;gap:8px;margin-bottom:12px;">
              <button class="btn btn-primary" onclick="loadAudit()">Load Audit</button>
              <button class="btn btn-ghost btn-sm" onclick="copyPre('outAudit')">Copy JSON</button>
            </div>
            <div class="help-text" style="margin-bottom:10px;">Latest 20 events, filtered by current Job ID if set.</div>
            <div class="out-wrap">
              <div class="out-header">
                <span class="out-title">audit · response</span>
              </div>
              <pre id="outAudit">{}</pre>
            </div>
          </div>
        </div>
        <div class="collapsible" id="secHealth">
          <div class="collapsible-header" onclick="toggleCollapsible('secHealth')">
            <div class="collapsible-header-left">
              <span style="font-size:15px;">🩺</span>
              <span class="card-title">Health Check</span>
              <span class="card-tag">GET /v1/health</span>
            </div>
            <div class="collapsible-toggle">▾</div>
          </div>
          <div class="collapsible-body">
            <div style="display:flex;gap:8px;margin-bottom:12px;">
              <button class="btn btn-primary" onclick="doHealth()">Check Health</button>
              <button class="btn btn-ghost btn-sm" onclick="copyPre('outHealth')">Copy JSON</button>
            </div>
            <div class="help-text" style="margin-bottom:10px;">Connectivity and upstream API status.</div>
            <div class="out-wrap">
              <div class="out-header">
                <span class="out-title">health · response</span>
              </div>
              <pre id="outHealth">{}</pre>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = "<?php echo htmlspecialchars($PDFJS_WORKER, ENT_QUOTES); ?>";
    let pollTimer = null;

    function pretty(o) {
      try {
        return JSON.stringify(o, null, 2);
      } catch {
        return String(o);
      }
    }

    function copyPre(id) {
      const el = document.getElementById(id);
      if (!el) return;
      navigator.clipboard && navigator.clipboard.writeText(el.textContent || '').catch(() => {});
    }

    function showError(msg) {
      const b = document.getElementById('errBox');
      if (!msg) {
        b.style.display = 'none';
        b.textContent = '';
        return;
      }
      b.style.display = 'block';
      b.textContent = String(msg);
    }

    function toggleCollapsible(id) {
      const el = document.getElementById(id);
      if (el) el.classList.toggle('open');
    }

    function openCollapsible(id) {
      const el = document.getElementById(id);
      if (el && !el.classList.contains('open')) el.classList.add('open');
    }

    function setStatusUi(status) {
      const dot = document.getElementById('statusDot');
      const val = document.getElementById('statusValue');
      val.textContent = status ? String(status) : '—';
      dot.className = 'status-dot';
      const s = (status || '').toString().toLowerCase();
      if (s === 'signed') dot.classList.add('ok');
      else if (['failed', 'expired', 'cancelled'].includes(s)) dot.classList.add('bad');
      else if (s) dot.classList.add('warn');
    }

    function setKpi(id, txt) {
      const el = document.getElementById(id);
      el.textContent = (txt === null || txt === undefined || txt === '') ? '—' : String(txt);
    }

    async function postJson(action, payload) {
      const fd = new FormData();
      fd.append('action', action);
      for (const k in payload) fd.append(k, payload[k]);
      const r = await fetch(location.href, {
        method: 'POST',
        body: fd
      });
      return await r.json();
    }

    async function doHealth() {
      const out = document.getElementById('outHealth');
      out.textContent = '…';
      const data = await postJson('health', {});
      out.textContent = pretty(data);
    }

    async function loadAudit() {
      const out = document.getElementById('outAudit');
      out.textContent = '…';
      const jobId = document.getElementById('jobId').value.trim();
      const data = await postJson('audit', {
        limit: '20',
        offset: '0',
        job_id: jobId || ''
      });
      out.textContent = pretty(data);
    }

    async function createJob(e) {
      e.preventDefault();
      const out = document.getElementById('outCreate');
      showError('');
      out.textContent = 'Creating job…';

      let preferredNodeId = '';
      const LOCAL_PORTS = [17700, 17656];
      for (const port of LOCAL_PORTS) {
        try {
          const ir = await fetch(`http://127.0.0.1:${port}/info`, {
            signal: AbortSignal.timeout(1500)
          });
          if (ir.ok) {
            const info = await ir.json();
            if (info && info.node_id) {
              preferredNodeId = info.node_id;
              break;
            }
          }
        } catch {}
      }

      if (!preferredNodeId) {
        showError('Signing agent not detected on this computer. Please make sure KB DSC Signer is running and try again.');
        out.textContent = '{}';
        return false;
      }

      const fd = new FormData(document.getElementById('formCreate'));
      fd.append('action', 'create_job_upload');
      fd.append('preferred_node_id', preferredNodeId);
      const r = await fetch(location.href, {
        method: 'POST',
        body: fd
      });
      const data = await r.json();
      out.textContent = pretty(data);

      const jobId = data && data.upstream && data.upstream.job_id ? data.upstream.job_id : '';
      if (jobId) {
        document.getElementById('jobId').value = jobId;
        document.getElementById('btnDownload').disabled = true;
        document.getElementById('btnForward').disabled = true;
        openCollapsible('secStatus');
        startPolling();
        document.getElementById('secStatus').scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
      return false;
    }

    function tzName() {
      try {
        return Intl.DateTimeFormat().resolvedOptions().timeZone || '';
      } catch {
        return '';
      }
    }

    function fmtLocal(dt) {
      const p = n => String(n).padStart(2, '0');
      return `${p(dt.getDate())}-${p(dt.getMonth()+1)}-${dt.getFullYear()} ${p(dt.getHours())}:${p(dt.getMinutes())}:${p(dt.getSeconds())}`;
    }

    function localClockTick() {
      const dt = new Date();
      const el = document.getElementById('localClock');
      if (el) el.value = fmtLocal(dt) + (tzName() ? ` (${tzName()})` : '');
    }
    setInterval(localClockTick, 1000);
    localClockTick();

    function toLocalDisplay(isoOrAny) {
      if (!isoOrAny) return '—';
      const d = new Date(isoOrAny);
      if (isNaN(d.getTime())) return String(isoOrAny);
      return fmtLocal(d) + (tzName() ? ` (${tzName()})` : '');
    }

    async function checkStatus() {
      const out = document.getElementById('outStatus');
      const jobId = document.getElementById('jobId').value.trim();
      if (!jobId) {
        out.textContent = pretty({
          ok: false,
          error: 'job_id_required'
        });
        return;
      }

      const data = await postJson('job_status', {
        job_id: jobId
      });
      const job = (data && data.upstream && data.upstream.job) ? data.upstream.job : null;
      const st = job && job.status ? job.status : null;

      setStatusUi(st);
      setKpi('kpiAttempts', (job && job.attempts !== undefined && job.max_attempts !== undefined) ? `${job.attempts} / ${job.max_attempts}` : '—');
      setKpi('kpiNode', job && job.assigned_node_id ? job.assigned_node_id : '—');

      let signer = '—';
      if (job && job.signer_cert && job.signer_cert.subject_dn) {
        const dn = String(job.signer_cert.subject_dn);
        const m = dn.match(/(?:^|,)\s*CN\s*=\s*([^,]+)/i) || dn.match(/^CN\s*=\s*([^,]+)/i);
        signer = (m && m[1]) ? m[1].trim() : '—';
      }
      setKpi('kpiSigner', signer);
      const signedAtRaw = (job && (job.signed_at || job.updated_at)) ? (job.signed_at || job.updated_at) : '';
      setKpi('kpiSignedAtLocal', signedAtRaw ? toLocalDisplay(signedAtRaw) : '—');

      const signed = (st || '').toString().toLowerCase() === 'signed';
      document.getElementById('btnDownload').disabled = !signed;
      document.getElementById('btnForward').disabled = !signed;

      out.textContent = `STATUS: ${st || '—'}\n\n` + pretty(data);

      if (['signed', 'failed', 'expired', 'cancelled'].includes((st || '').toString().toLowerCase())) stopPolling();
    }

    function startPolling() {
      stopPolling();
      pollTimer = setInterval(checkStatus, 3000);
      checkStatus();
    }

    function stopPolling() {
      if (pollTimer) clearInterval(pollTimer);
      pollTimer = null;
    }

    function downloadPdf() {
      const jobId = document.getElementById('jobId').value.trim();
      if (!jobId) return alert('Job ID required');
      const lt = fmtLocal(new Date());
      const tz = tzName();
      const qs = new URLSearchParams();
      qs.set('action', 'download_pdf');
      qs.set('job_id', jobId);
      qs.set('local_time', lt);
      if (tz) qs.set('tz', tz);
      window.location.href = location.pathname + '?' + qs.toString();
    }
    let chosenFile = null;

    function onFileChosen(file) {
      chosenFile = file || null;
      document.getElementById('btnUploadPreview').disabled = !chosenFile;
      document.getElementById('btnCreateJob').disabled = true;
      document.getElementById('preview_id').value = '';
      clearBox();
      const hint = document.getElementById('dropHint');
      if (chosenFile) {
        hint.textContent = chosenFile.name + ' · ' + (chosenFile.size > 1048576 ? (chosenFile.size / 1048576).toFixed(1) + ' MB' : Math.round(chosenFile.size / 1024) + ' KB');
      } else {
        hint.textContent = 'PDF only · Max recommended 20 MB';
      }
    }

    // Drag-over styling for drop zone
    const dz = document.getElementById('dropZone');
    dz.addEventListener('dragover', e => {
      e.preventDefault();
      dz.classList.add('dragover');
    });
    dz.addEventListener('dragleave', () => dz.classList.remove('dragover'));
    dz.addEventListener('drop', e => {
      e.preventDefault();
      dz.classList.remove('dragover');
      const f = e.dataTransfer.files[0];
      if (f) {
        document.getElementById('pdfFile').files;
        onFileChosen(f);
      }
    });

    async function uploadAndPreview() {
      if (!chosenFile) return alert('Select a PDF first.');
      const btn = document.getElementById('btnUploadPreview');
      btn.disabled = true;
      btn.textContent = 'Uploading…';
      showError('');

      const fd = new FormData();
      fd.append('pdf', chosenFile);
      fd.append('action', 'upload_preview');

      const r = await fetch(location.href, {
        method: 'POST',
        body: fd
      });
      const data = await r.json();

      if (!data || !data.ok) {
        btn.disabled = false;
        btn.textContent = 'Upload & Preview PDF';
        showError('Upload failed: ' + (data && data.error ? data.error : 'unknown'));
        return;
      }

      document.getElementById('preview_id').value = data.preview_id;
      await loadPdfFromUrl(data.preview_url);
      document.getElementById('btnCreateJob').disabled = false;
      btn.textContent = '✓ Uploaded';
      setTimeout(() => {
        btn.textContent = 'Upload & Preview PDF';
        btn.disabled = false;
      }, 1200);
    }

    let pdfDoc = null,
      pdfPageNum = 1,
      pdfTotalPages = 0,
      renderScale = 1.35;
    const canvas = document.getElementById('pdfCanvas');
    const stage = document.getElementById('stage');
    const sigBox = document.getElementById('sigBox');
    const sigLabel = document.getElementById('sigLabel');

    let dragging = false,
      dragRect = null;
    let presetWpt = 200,
      presetHpt = 60;

    function setBoxPreset(size) {
      if (size === 'S') {
        presetWpt = 160;
        presetHpt = 45;
      }
      if (size === 'M') {
        presetWpt = 200;
        presetHpt = 60;
      }
      if (size === 'L') {
        presetWpt = 240;
        presetHpt = 75;
      }
      document.getElementById('vs_w').value = String(presetWpt);
      document.getElementById('vs_h').value = String(presetHpt);
    }

    function clearBox() {
      sigBox.style.display = 'none';
      dragRect = null;
    }

    async function loadPdfFromUrl(url) {
      clearBox();
      document.getElementById('pdfInfo').textContent = 'Loading…';
      const loadingTask = pdfjsLib.getDocument(url);
      pdfDoc = await loadingTask.promise;
      pdfTotalPages = pdfDoc.numPages;
      pdfPageNum = 1;
      document.getElementById('vs_page').value = String(pdfPageNum);
      await renderPage();
    }

    async function renderPage() {
      if (!pdfDoc) return;
      const page = await pdfDoc.getPage(pdfPageNum);
      const viewport = page.getViewport({
        scale: renderScale
      });
      const nativeViewport = page.getViewport({
        scale: 1.0
      });
      window.pdfPageWidthPt = nativeViewport.width;
      window.pdfPageHeightPt = nativeViewport.height;
      canvas.width = Math.floor(viewport.width);
      canvas.height = Math.floor(viewport.height);
      const ctx = canvas.getContext('2d', {
        alpha: false
      });
      ctx.setTransform(1, 0, 0, 1, 0, 0);
      await page.render({
        canvasContext: ctx,
        viewport
      }).promise;
      document.getElementById('pdfInfo').textContent = `Page ${pdfPageNum} / ${pdfTotalPages}  ·  ${Math.round(renderScale*100)}%`;
      document.getElementById('vs_page').value = String(pdfPageNum);
    }

    function prevPage() {
      if (!pdfDoc || pdfPageNum <= 1) return;
      pdfPageNum--;
      clearBox();
      renderPage();
    }

    function nextPage() {
      if (!pdfDoc || pdfPageNum >= pdfTotalPages) return;
      pdfPageNum++;
      clearBox();
      renderPage();
    }

    function zoomIn() {
      if (!pdfDoc) return;
      renderScale = Math.min(3.0, renderScale + 0.15);
      clearBox();
      renderPage();
    }

    function zoomOut() {
      if (!pdfDoc) return;
      renderScale = Math.max(0.6, renderScale - 0.15);
      clearBox();
      renderPage();
    }

    function getCanvasPos(evt) {
      const rect = canvas.getBoundingClientRect();
      return {
        x: (evt.clientX || 0) - rect.left,
        y: (evt.clientY || 0) - rect.top
      };
    }

    function clamp(v, min, max) {
      return Math.max(min, Math.min(max, v));
    }

    function canvasPxToPdfPt(pxX, pxY) {
      const pageW = window.pdfPageWidthPt || canvas.width / renderScale;
      const pageH = window.pdfPageHeightPt || canvas.height / renderScale;
      return {
        xPt: (pxX / canvas.width) * pageW,
        yPt: ((canvas.height - pxY) / canvas.height) * pageH
      };
    }

    function showOverlay(x1, y1, x2, y2) {
      const left = Math.min(x1, x2),
        top = Math.min(y1, y2);
      const w = Math.abs(x2 - x1),
        h = Math.abs(y2 - y1);
      const stageRect = stage.getBoundingClientRect();
      const canvasRect = canvas.getBoundingClientRect();
      const offsetX = (canvasRect.left - stageRect.left) + stage.scrollLeft;
      const offsetY = (canvasRect.top - stageRect.top) + stage.scrollTop;
      sigBox.style.display = 'block';
      sigBox.style.left = (offsetX + left) + 'px';
      sigBox.style.top = (offsetY + top) + 'px';
      sigBox.style.width = Math.max(1, w) + 'px';
      sigBox.style.height = Math.max(1, h) + 'px';
    }

    function applyRectToFields(x1, y1, x2, y2) {
      const leftPx = Math.min(x1, x2),
        rightPx = Math.max(x1, x2);
      const topPx = Math.min(y1, y2),
        bottomPx = Math.max(y1, y2);
      const ll = canvasPxToPdfPt(leftPx, bottomPx);
      const ur = canvasPxToPdfPt(rightPx, topPx);
      const llx = Math.round(ll.xPt),
        lly = Math.round(ll.yPt);
      const urx = Math.round(ur.xPt),
        ury = Math.round(ur.yPt);
      document.getElementById('vs_page').value = String(pdfPageNum);
      document.getElementById('vs_x').value = String(Math.max(0, llx));
      document.getElementById('vs_y').value = String(Math.max(0, lly));
      document.getElementById('vs_w').value = String(Math.max(1, urx - llx));
      document.getElementById('vs_h').value = String(Math.max(1, ury - lly));
    }

    function placePresetAt(pxX, pxY) {
      const wPx = presetWpt * renderScale,
        hPx = presetHpt * renderScale;
      const x1 = clamp(pxX, 0, canvas.width - wPx);
      const y1 = clamp(pxY, 0, canvas.height - hPx);
      dragRect = {
        x1,
        y1,
        x2: x1 + wPx,
        y2: y1 + hPx
      };
      showOverlay(dragRect.x1, dragRect.y1, dragRect.x2, dragRect.y2);
      applyRectToFields(dragRect.x1, dragRect.y1, dragRect.x2, dragRect.y2);
    }

    canvas.addEventListener('mousedown', e => {
      if (!pdfDoc) return;
      const p = getCanvasPos(e);
      if (p.x < 0 || p.y < 0 || p.x > canvas.width || p.y > canvas.height) return;
      dragging = true;
      dragRect = {
        x1: p.x,
        y1: p.y,
        x2: p.x,
        y2: p.y
      };
      showOverlay(dragRect.x1, dragRect.y1, dragRect.x2, dragRect.y2);
    });
    document.addEventListener('mousemove', e => {
      if (!dragging || !dragRect) return;
      const p = getCanvasPos(e);
      dragRect.x2 = clamp(p.x, 0, canvas.width);
      dragRect.y2 = clamp(p.y, 0, canvas.height);
      showOverlay(dragRect.x1, dragRect.y1, dragRect.x2, dragRect.y2);
    });
    document.addEventListener('mouseup', e => {
      if (!dragging || !dragRect) return;
      dragging = false;
      const w = Math.abs(dragRect.x2 - dragRect.x1);
      const h = Math.abs(dragRect.y2 - dragRect.y1);
      if (w < 10 || h < 10) {
        const p = getCanvasPos(e);
        placePresetAt(clamp(p.x, 0, canvas.width), clamp(p.y, 0, canvas.height));
        return;
      }
      applyRectToFields(dragRect.x1, dragRect.y1, dragRect.x2, dragRect.y2);
    });
    setBoxPreset('M');
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function forwardSignedUC() {
      Swal.fire({
        title: "Are you sure?",
        text: "You want to forward signed UC",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Forward"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "forward_dsc.php",
            type: "POST",
            data: {
              status: 1
            },
            success: function(response) {
              if (response.trim() === "success") {
                downloadPdf();
                Swal.fire({
                  icon: "success",
                  title: "Forwarded!",
                  text: "Signed UC forwarded successfully",
                  timer: 2000,
                  showConfirmButton: false
                }).then(() => {
                  location.reload();
                });
              } else {
                Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: "Failed to update status"
                });
              }
            },
            error: function() {
              Swal.fire({
                icon: "error",
                title: "Server Error",
                text: "Something went wrong!"
              });
            }
          });
        }
      });
    }
  </script>
</body>

</html>