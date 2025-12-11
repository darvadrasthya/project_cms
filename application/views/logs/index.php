<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Activity Logs</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Activity Logs</li>
                </ol>
            </nav>
        </div>
        <div>
            <div class="btn-group">
                <a href="<?php echo base_url('logs?type=audit'); ?>" class="btn btn-outline-primary <?php echo (!isset($_GET['type']) || $_GET['type'] == 'audit') ? 'active' : ''; ?>">Audit Logs</a>
                <a href="<?php echo base_url('logs?type=crud'); ?>" class="btn btn-outline-primary <?php echo (isset($_GET['type']) && $_GET['type'] == 'crud') ? 'active' : ''; ?>">CRUD Logs</a>
                <a href="<?php echo base_url('logs?type=traffic'); ?>" class="btn btn-outline-primary <?php echo (isset($_GET['type']) && $_GET['type'] == 'traffic') ? 'active' : ''; ?>">Traffic Logs</a>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <?php if (!isset($_GET['type']) || $_GET['type'] == 'audit') : ?>
                                <th>Time</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Details</th>
                                <th>IP Address</th>
                            <?php elseif ($_GET['type'] == 'crud') : ?>
                                <th>Time</th>
                                <th>User</th>
                                <th>Table</th>
                                <th>Operation</th>
                                <th>Record ID</th>
                                <th>Description</th>
                            <?php else : ?>
                                <th>Time</th>
                                <th>User</th>
                                <th>URL</th>
                                <th>Device</th>
                                <th>Browser</th>
                                <th>IP Address</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($logs) && !empty($logs)) : ?>
                            <?php foreach ($logs as $log) : ?>
                                <tr>
                                    <?php if (!isset($_GET['type']) || $_GET['type'] == 'audit') : ?>
                                        <td><small><?php echo date('d M Y H:i:s', strtotime($log['created_at'])); ?></small></td>
                                        <td><?php echo htmlspecialchars($log['username'] ?? 'System'); ?></td>
                                        <td><span class="badge bg-info"><?php echo htmlspecialchars($log['action']); ?></span></td>
                                        <td><small><?php echo htmlspecialchars(substr($log['details'] ?? '', 0, 100)); ?></small></td>
                                        <td><code><?php echo htmlspecialchars($log['ip_address']); ?></code></td>
                                    <?php elseif ($_GET['type'] == 'crud') : ?>
                                        <td><small><?php echo date('d M Y H:i:s', strtotime($log['created_at'])); ?></small></td>
                                        <td><?php echo htmlspecialchars($log['username'] ?? 'System'); ?></td>
                                        <td><code><?php echo htmlspecialchars($log['table_name']); ?></code></td>
                                        <td>
                                            <?php
                                            $op_class = [
                                                'create' => 'success',
                                                'update' => 'warning',
                                                'delete' => 'danger'
                                            ];
                                            $class = $op_class[$log['action']] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?php echo $class; ?>"><?php echo strtoupper($log['action']); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($log['record_id']); ?></td>
                                        <td><small><?php echo htmlspecialchars($log['description'] ?? ''); ?></small></td>
                                    <?php else : ?>
                                        <td><small><?php echo date('d M Y H:i:s', strtotime($log['accessed_at'])); ?></small></td>
                                        <td><?php echo htmlspecialchars($log['username'] ?? 'Guest'); ?></td>
                                        <td><code><?php echo htmlspecialchars($log['url_path'] ?? '/'); ?></code></td>
                                        <td><?php echo htmlspecialchars($log['device'] ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($log['browser'] ?? '-'); ?></td>
                                        <td><code><?php echo htmlspecialchars($log['ip_address']); ?></code></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-journal-x" style="font-size: 3em;"></i>
                                    <p class="mt-2">No logs found</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
