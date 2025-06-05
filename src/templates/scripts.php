<?php
/**
 * Scripts Template
 *
 * Contains JavaScript references for SitoBanda website
 *
 * @author   SitoBanda Team
 * @version  1.0.0
 */
?>
<!-- Global Mailform Output-->
<div class="snackbars" id="form-output-global"></div>

<?php if (isset($pageStructuredData)) : ?>
<!-- Structured Data -->
<script type="application/ld+json">
<?php echo $pageStructuredData; ?>
</script>
<?php endif; ?>

<!-- Javascript-->
<script src="<?= SITE_URL ?>/assets/js/core.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/script.js"></script>

<?php if (isset($pageCustomScripts)) : ?>
<!-- Page Custom Scripts -->
<?php echo $pageCustomScripts; ?>
<?php endif; ?>
