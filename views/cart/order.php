<?
    use yii\widgets\ActiveForm;
?>

<h2>oformlenie zakaxa</h2>
<? $form = ActiveForm::begin() ?>

<?= $form->field($order, 'name') ?>
<?= $form->field($order, 'email') ?>
<?= $form->field($order, 'phone') ?>
<?= $form->field($order, 'address') ?>
<button class="btn btn-success">Оформить заказ</button>

<? ActiveForm::end() ?>

