<?= $this->extend("layout/template")?>
<?= $this->section('content')?>
<section class="min-vh-100 bg_light">
    <div class="container-fluid bg_green bg_green_title">
        <div class="row justify-content-center">
            <div class="col-md-8 row justify-content-center align-items-center">
                <div class="col-1 p-0">
                    <a href="<?= base_url('/quizlets') ?>" class="btn btn_low_key p-0"><i class="fa-fw fa-regular fa-hand-point-left"></i></a>
                </div>
                <div class="col-10 pt-3 pb-4">
                    <div class="fs-3 text-center">建立測驗吧</div>
                </div>
                <div class="col-1">
                </div>
            </div>
        </div>
    </div>

    <div class="container py-3">
        <div class="row justify-content-center mb-3">
            <div class="col-md-8 my-3">
                <form id="quizMainForm">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="text-center fs-3 mb-3">建立新測驗吧</div>
                            <div class="fs-5 mb-2">1. 選擇出題方式</div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="" class="form-label">出題方式</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-check-input" type="radio" name="main_way" id="main_way1" value="system" required checked>
                                    <label class="form-check-label" for="main_way1">系統出題</label>
                                    <br>
                                    <input class="form-check-input" type="radio" name="main_way" id="main_way2" value="self" disabled>
                                    <label class="form-check-label" for="main_way2">自定義題目</label>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="" class="form-label">測驗方式</label>
                                </div>
                                <div class="col-9">
                                    <input class="form-check-input" type="radio" name="quiz_type" id="quiz_type1" value="flashcard" required checked>
                                    <label class="form-check-label" for="quiz_type1">翻卡</label>
                                    <br>
                                    <input class="form-check-input" type="radio" name="quiz_type" id="quiz_type2" value="spelling" disabled>
                                    <label class="form-check-label" for="quiz_type2">拼字</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 d-none">
                        <div class="card-body">
                            <div class="fs-5 mb-2">2. 詳細設定</div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="title" class="form-label">選擇書本</label>
                                </div>
                                <div class="col-9">
                                    <?php foreach($books as $row):?>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="book_group" value="<?= $row['b_id']?>"><?= $row['title']?></div>
                                    <?php endforeach;?>
                                    <span id="bookError" class="text-danger d-none" >請選擇至少一個書本</span>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="select_state" class="form-label">字卡狀態</label>
                                </div>
                                <div class="col-9">
                                    <select name="select_state"id="select_state" class="form-select">
                                        <option value="未測驗">未測驗</option>
                                        <option value="已測驗">已測驗</option>
                                        <option value="差">差</option>
                                        <option value="弱">弱</option>
                                        <option value="中">中</option>
                                        <option value="可">可</option>
                                        <option value="佳">佳</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="select_old" class="form-label">未複習逾</label>
                                </div>
                                <div class="col-9">
                                    <select name="select_old"id="select_old" class="form-select">
                                        <option value="0">不限</option>
                                        <option value="3">3天</option>
                                        <option value="7">7天</option>
                                        <option value="10">10天</option>
                                        <option value="15">15天</option>
                                        <option value="30">30天</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="select_wrong" class="form-label">近一月逾</label>
                                </div>
                                <div class="col-9">
                                    <select name="select_wrong"id="select_wrong" class="form-select">
                                        <option value="0">不限</option>
                                        <option value="5">5錯誤</option>
                                        <option value="10">10錯誤</option>
                                        <option value="15">15錯誤</option>
                                        <option value="30">30錯誤</option>
                                        <option value="50">50錯誤</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="fs-5 mb-2">3. 選擇數量並送出</div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="select_amount" class="form-label">測驗數量</label>
                                </div>
                                <div class="col-9">
                                    <select name="select_amount"id="select_amount" class="form-select">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="500">500</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" name="submit" class="btn">送出</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
<script>
    let quizMainForm = document.getElementById("quizMainForm");

    quizMainForm.addEventListener("submit",(e) => {
        let formdata = new FormData(quizMainForm);

        let select_book = new Array();
        if(formdata.get('main_way') == "self"){
            $.each($("input[name='book_group']:checked"), function() {
                select_book.push(parseInt($(this).val()));
            });
            if(select_book.length==0){
                document.getElementById('bookError').classList.remove('d-none');
            }else{
                document.getElementById('bookError').classList.add('d-none');
            }
        }else{
            $.each($("input[name='book_group']"), function() {
                select_book.push(parseInt($(this).val()));
            });
        }

        e.preventDefault();
        formdata.append("select_book", select_book);
        quizCreateComponent.POST("<?= base_url('/quizlets/new') ?>",formdata);
    })

    let quizCreateComponent = {
        POST: (url,formdata) => {
            axios.post(url,formdata)
            .then((response) => {
                Swal.fire({
                    icon: 'success',
                    title: '成功',
                    text: '您好，即將開始測驗'
                }).then(function(result) {
                    window.location.href = `<?= base_url('/quizlets/quizzing')?>`;
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