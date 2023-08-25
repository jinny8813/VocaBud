<?= $this->extend("layout/template")?>
<?= $this->section('content')?>
<section class="min-vh-100 bg_light">
    <div class="container-fluid bg_green">
        <div class="row justify-content-center">
            <div class="col-md-8 row justify-content-center align-items-center">
                <div class="col-1 p-0">
                    <a href="<?= base_url('/home')?>" class="btn btn_low_key p-0"><i class="fa-fw fa-regular fa-hand-point-left"></i></a>
                </div>
                <div class="col-1 p-0">
                    <a href="#" class="btn btn_low_key p-0"><i class="fa-fw fa-solid fa-info"></i></a>
                </div>
                <div class="col-8 p-3">
                    <div class="fs-3 text-center">個人設定</div>
                </div>
                <div class="col-1">
                </div>
                <div class="col-1 p-1">
                    <a href="<?= base_url('/personal/'.$uuid.'/edit') ?>" class="btn btn_low_key p-0"><i class="fa-fw fa-solid fa-pen-to-square"></i></a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-10 pb-4">
                <div>-</div>
                <div>-</div>
            </div>
        </div>
    </div>

    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">個人資料</div>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                <th colspan="2">個人資料</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">電子信箱</th>
                                <td><?= esc($email)?></td>
                                </tr>
                                <tr>
                                <th scope="row">密碼</th>
                                <td>不顯示</td>
                                </tr>
                                <tr>
                                <th scope="row">暱稱</th>
                                <td><?= esc($nickname)?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">其他設定</div>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                <th colspan="2">其他設定</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">每日測驗目標</th>
                                <td><?= esc($goal)?></td>
                                </tr>
                                <tr>
                                <th scope="row">測驗計算期間</th>
                                <td><?= esc($lasting)?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">登出帳號</div>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center py-2"><a href="<?= base_url("/logout") ?>" class="a_black stretched-link">登出</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection()?>