<script src="<?= base_url('assets/js/jquery.validate.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/validasi.js'); ?>"></script>
<script src="<?= base_url('assets/js/localization/messages_id.js'); ?>"></script>

<?php IF($_SESSION['UI'] === 'ADMIN'): ?>
<script src="<?= base_url('assets/js/script.js'); ?>"></script>
<?php ENDIF ?>

<?php IF($_SESSION['UI'] === 'WEB'): ?>
<script src="<?= base_url('assets/js/script-web.js'); ?>"></script>
<?php ENDIF ?>
