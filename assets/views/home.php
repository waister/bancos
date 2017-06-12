<?php

$docs = [
    [
        'label' => 'Definir bancos principais:',
        'data' => '?priority=001,184,104,237',
    ],
    [
        'label' => 'Definir ordem de exibição',
        'data' => '?sort=code:desc',
    ],
    [
        'label' => 'Informar quais bancos quer mostrar:',
        'data' => '?only=001,184,749',
    ],
    [
        'label' => 'Mostrar todos os bancos exceto alguns:',
        'data' => '?except=001,184',
    ],
];

?>
<div class="title m-b-md">
    API Rest dos bancos do Brasil
</div>
<div>
    <div class="line">
        <div class="label">Link da API:</div>
        <div class="data"><?php echo API_URL; ?></div>
    </div>

    <?php foreach ($docs as $item) { ?>
        <div class="line">
            <div class="label"><?php echo $item['label']; ?>:</div>
            <div class="data">
                <a href="<?php echo API_URL . $item['data']; ?>" class="link" target="_blank">
                    <span class="tag">API</span><?php echo $item['data']; ?>
                </a>
            </div>
        </div>
    <?php } ?>

</div>