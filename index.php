<?php
declare(strict_types=1);
session_start();
require __DIR__ . '/app/bootstrap.php';

use App\CandidateRepository;
use App\Database;
use App\CandidateService;
use App\Html;

$repo = new CandidateRepository(Database::connect());
$service = new CandidateService($repo);
$errors = [];
$notice = '';
$editing = null;
$search = trim((string)($_GET['q'] ?? ''));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''))) {
        http_response_code(419);
        exit('Nag-expire ang request. I-refresh ang page at subukan ulit.');
    }
    $action = (string)($_POST['action'] ?? '');
    try {
        if ($action === 'save') {
            $service->save($_POST, isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null);
            header('Location: index.php?notice=' . rawurlencode('Naisave ang kandidato.')); exit;
        }
        if ($action === 'delete') {
            $service->remove((int)($_POST['id'] ?? 0));
            header('Location: index.php?notice=' . rawurlencode('Inilipat sa archive ang kandidato.')); exit;
        }
    } catch (InvalidArgumentException $e) { $errors[] = $e->getMessage(); }
}
if (isset($_GET['edit'])) { $editing = $repo->find((int)$_GET['edit']); }
$notice = (string)($_GET['notice'] ?? '');
$_SESSION['csrf'] = bin2hex(random_bytes(32));
$candidates = $repo->all($search);
function csrf(): string { return Html::escape($_SESSION['csrf'] ?? ''); }
function old(string $key, array $errors, ?array $editing): string { return Html::escape((string)($_POST[$key] ?? ($editing[$key] ?? ''))); }
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Candidate Information System</title><link rel="stylesheet" href="assets/styles.css"></head>
<body><header class="top"><div class="wrap"><span class="brand">CCDI · BSIT</span><a href="index.php">Candidate Information System</a></div></header>
<main class="wrap"><section class="intro"><p class="eyebrow">CRUD INFORMATION SYSTEM</p><h1>Candidate Records</h1><p>Manage candidate information with validated forms, search, editing, and archive.</p></section>
<?php if ($notice): ?><div class="notice"><?= Html::escape($notice) ?></div><?php endif ?>
<?php if ($errors): ?><div class="error" role="alert"><?php foreach ($errors as $error): ?><p><?= Html::escape($error) ?></p><?php endforeach ?></div><?php endif ?>
<div class="layout"><section class="panel"><h2><?= $editing ? 'Edit candidate' : 'Add candidate' ?></h2>
<form method="post" action="index.php"><input type="hidden" name="csrf" value="<?= csrf() ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= $editing ? (int)$editing['id'] : '' ?>">
<label>Full name<input name="name" required maxlength="100" value="<?= old('name', $errors, $editing) ?>" placeholder="e.g. Juan Dela Cruz"></label>
<label>Position<input name="position" required maxlength="80" value="<?= old('position', $errors, $editing) ?>" placeholder="e.g. President"></label>
<label>Party / group<input name="party" maxlength="100" value="<?= old('party', $errors, $editing) ?>" placeholder="Optional"></label>
<label>Platform<textarea name="platform" rows="4" maxlength="1000" placeholder="Short candidate platform"><?= old('platform', $errors, $editing) ?></textarea></label>
<div class="actions"><button class="primary" type="submit"><?= $editing ? 'Save changes' : 'Add candidate' ?></button><?php if ($editing): ?><a class="button" href="index.php">Cancel</a><?php endif ?></div></form></section>
<section class="panel records"><div class="list-head"><div><h2>Candidate list</h2><p><?= count($candidates) ?> active record(s)</p></div><form method="get" class="search"><input name="q" value="<?= Html::escape($search) ?>" placeholder="Search name, position, group"><button class="button">Search</button></form></div>
<?php if (!$candidates): ?><div class="empty">No candidates found. Add a record using the form.</div><?php else: ?><div class="table-wrap"><table><thead><tr><th>Name</th><th>Position</th><th>Party / group</th><th>Platform</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($candidates as $candidate): ?><tr><td data-label="Name"><strong><?= Html::escape($candidate['name']) ?></strong></td><td data-label="Position"><?= Html::escape($candidate['position']) ?></td><td data-label="Party / group"><?= Html::escape($candidate['party'] ?: '—') ?></td><td data-label="Platform"><?= Html::escape($candidate['platform'] ?: '—') ?></td><td data-label="Actions" class="row-actions"><a href="?edit=<?= (int)$candidate['id'] ?>">Edit</a><form method="post" onsubmit="return confirm('I-archive ang record na ito? Maaari pa itong ibalik sa database.');"><input type="hidden" name="csrf" value="<?= csrf() ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$candidate['id'] ?>"><button class="link danger" type="submit">Archive</button></form></td></tr><?php endforeach ?>
</tbody></table></div><?php endif ?></section></div><footer>Candidate Information System · PHP + MySQL · Local XAMPP project</footer></main></body></html>


