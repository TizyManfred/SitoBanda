<?php
/**
 * Admin Body End Template - AdminLTE 3 Version
 *
 * Contains closing content wrapper and scripts
 * Following PSR-12 coding standards and accessibility best practices
 */
?>

</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<?php include_once __DIR__ . '/footer_adminlte.php'; ?>

<?php if (isset($additionalScripts) && is_array($additionalScripts)): ?>
<!-- Page specific scripts -->
<?php foreach ($additionalScripts as $script): ?>
<script src="<?php echo SITE_URL; ?>/admin/<?php echo htmlspecialchars($script); ?>"></script>
<?php endforeach; ?>
<?php endif; ?>

</body>
</html>
