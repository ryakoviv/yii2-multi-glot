<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use borales\extensions\phoneInput\PhoneInput;
use kartik\file\FileInput;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options'=>['enctype'=>'multipart/form-data']]); ?>

                <?= $form->field($model, 'user_name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email')->input('email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'password_repeat')->passwordInput() ?>

                <?= $form->field($model, 'sex')->dropDownList($model::SEX_ARRAY)?>

                <?= $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-dd-mm',
                    ]
                ]);?>

                <?= $form->field($model, 'role')->dropDownList($model::ROLE_ARRAY)?>

                <?= $form->field($model, 'avatar')->widget(FileInput::classname(), [
                    'pluginOptions' => [
                        'showUpload' => false
                    ],
                    'options' => ['accept' => 'image/*'],
                ]);?>

                <?= $form->field($model, 'skype') ?>

                <?= $form->field($model, 'phone')->widget(PhoneInput::className(), [
                    'options'=>['class'=>'form-control phone-number'],
                    'jsOptions' => [
                        'preferredCountries' => ['ua', 'us', 'pl', 'ru'],
                        'nationalMode' => true,
                    ]
                ]); ?>

                <?= $form->field($model, 'country') ?>

                <?= $form->field($model, 'city') ?>

                <?= $form->field($model, 'about')->textarea()?>

                <?= $form->field($model, 'interest')->textarea()?>


            <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$this->registerJs(
    '
    $("form").submit(function() {
        $("#signupform-phone").val($("#signupform-phone").intlTelInput("getNumber"));
    });'
);
?>