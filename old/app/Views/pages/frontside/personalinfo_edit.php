<?= $this->extend("layout/frontside/template")?>
<?= $this->section('frontside_content')?>
<section class="min-vh-100 bg_light">
    <div class="container-fluid bg_green bg_green_title">
        <div class="row justify-content-center">
            <div class="col-md-8 row justify-content-center align-items-center">
                <div class="col-1 p-0">
                    <a href="<?= base_url('/personal/'.$uuid) ?>" class="btn btn_low_key p-0"><i class="fa-fw fa-regular fa-hand-point-left"></i></a>
                </div>
                <div class="col-10 pt-3 pb-4">
                    <div class="fs-3 text-center">修改個人資料</div>
                </div>
                <div class="col-1">
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center my-3">
            <div class="col-md-8 my-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center fs-3 mb-3">修改個人資料</div>
                        <form id="infoEditForm">
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="email" class="form-label">電子信箱</label>
                                </div>
                                <div class="col-9">
                                    <input type="email" name="email" class="form-control" value="<?= esc($email)?>" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="password" class="form-label">密碼</label>
                                </div>
                                <div class="col-9">
                                    <input type="password" name="password" class="form-control" placeholder="請輸入新密碼，如未修改跳過">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="cpassword" class="form-label">密碼驗證</label>
                                </div>
                                <div class="col-9">
                                    <input type="password" name="cpassword" class="form-control" placeholder="密碼驗證">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="nickname" class="form-label">暱稱</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="nickname" class="form-control" value="<?= esc($nickname)?>" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="goal" class="form-label">每日測驗目標</label>
                                </div>
                                <div class="col-9">
                                    <input type="number" name="goal" class="form-control" value="<?= esc($goal)?>" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="lasting" class="form-label">測驗計算期間</label>
                                </div>
                                <div class="col-9">
                                    <input type="number" name="lasting" class="form-control" value="<?= esc($lasting)?>" required>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" name="submit" class="btn">修改</button>
                            </div>
                        </form>
                        <br>
                        <div class="d-flex justify-content-center">
                            <button id="deleteInfoBtn" class="btn">刪除此帳號</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    let infoEditForm = document.getElementById("infoEditForm");

    infoEditForm.addEventListener("submit",(e) => {
        e.preventDefault();
        let formdata= new FormData(infoEditForm);
        infoEditComponent.PUT("<?= base_url('/personal/'.$uuid) ?>", JSON.stringify(Object.fromEntries(formdata)));
    })

    let infoEditComponent = {
        PUT: (url,data) => {
            axios.put(url,data)
            .then((response) => {
                Swal.fire({
                    icon: 'success',
                    title: '成功',
                    text: '您好，即將為您重新轉跳'
                }).then(function(result) {
                    window.location.href = `<?= base_url('/personal/'.$uuid) ?>`;
                })
            })
            .catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: error.response.data.status + ' 錯誤',
                    text: error.response.data.messages
                })
            })
        },
    }

    let deleteInfoBtn = document.getElementById("deleteInfoBtn");

    deleteInfoBtn.addEventListener("click",(e) => {
        e.preventDefault();
        infoDeleteComponent.Delete("<?= base_url('/personal/'.$uuid) ?>");
    })

    let infoDeleteComponent = {
        Delete: (url) => {
            axios.delete(url)
            .then((response) => {
                Swal.fire({
                    icon: 'success',
                    title: '成功',
                    text: '您好，即將為您重新轉跳'
                }).then(function(result) {
                    window.location.href = `<?= base_url('/logout') ?>`;
                })
            })
            .catch((error) => {
                console.log(error);
                Swal.fire({
                    icon: 'error',
                    title: error.response.data.status + ' 錯誤',
                    text: error.response.data.messages
                })
            })
        },
    }
</script>
<?= $this->endSection()?>