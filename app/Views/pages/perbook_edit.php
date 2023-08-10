<?= $this->extend("layout/template")?>
<?= $this->section('content')?>
<section class="min-vh-100 bg_light">
    <div class="container-fluid bg_green bg_green_title">
        <div class="row justify-content-center">
            <div class="col-md-8 row justify-content-center align-items-center">
                <div class="col-1 p-0">
                    <a href="<?= base_url('/perbook/'.$uuidv4) ?>" class="btn btn_low_key p-0"><i class="fa-fw fa-regular fa-hand-point-left"></i></a>
                </div>
                <div class="col-10 pt-3 pb-4">
                    <div class="fs-3 text-center">修改書本資料</div>
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
                        <div class="text-center fs-3 mb-3">修改書本</div>
                        <form id="bookEditForm">
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="title" class="form-label">書本標題</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="title" class="form-control" value="<?= esc($title)?>" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="description" class="form-label">書本描述</label>
                                </div>
                                <div class="col-9">
                                    <textarea name="description" class="form-control" rows="8" required><?= esc($description)?></textarea>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" name="submit" class="btn">修改</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    let bookEditForm = document.getElementById("bookEditForm");

    bookEditForm.addEventListener("submit",(e) => {
        e.preventDefault();
        let formdata= new FormData(bookEditForm);
        bookEditComponent.PUT("<?= base_url('/perbook/'.$uuidv4) ?>", JSON.stringify(Object.fromEntries(formdata)));
    })

    let bookEditComponent = {
        PUT: (url,data) => {
            axios.put(url,data)
            .then((response) => {
                Swal.fire({
                    icon: 'success',
                    title: '成功',
                    text: '您好，即將為您重新轉跳'
                }).then(function(result) {
                    window.location.href = `<?= base_url('/perbook/'.$uuidv4) ?>`;
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
</script>
<?= $this->endSection()?>