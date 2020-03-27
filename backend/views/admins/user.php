<?php
    use kartik\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'email',
        'profile.name',
        'profile.member_type',
        'profile.tel',
        'profile.link'
    ],
]) ?>