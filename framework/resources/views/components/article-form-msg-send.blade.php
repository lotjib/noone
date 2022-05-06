<div class="col-12 py-2">
    <div id="msgForm">
        <div class="alert alert-danger d-none" id="errors">

        </div>
        <form id="goMsg">
            <div class="mb-3">
                <label for="title" class="form-label">Тема сообщения</label>
                <input type="text" name="title" class="form-control" id="title" required/>
            </div>
            <div class="mb-3">
                <label for="body" class="form-label">Текст сообщения</label>
                <textarea class="form-control" name="body" id="body" rows="3"></textarea>
            </div>
            <div class="">
                <button type="submit" class="btn btn-outline-success">Отправить</button>
            </div>
        </form>
    </div>
    <script>
        let block = document.getElementById('msgForm')
        let goMsg = document.getElementById('goMsg')
        let err_block = document.getElementById('errors')
        let submitForm = (event) => {
            err_block.classList.add('d-none')
            let server = '{{url('/api')}}';
            event.preventDefault()
            let promise = new Promise((resolve, reject) => {
                let data = new FormData(event.target)
                data.append('id_article', '{{$article->id}}')
                data.append('user_tredium_session', user)
                axios.post(server + '/sendMsgToArticle', data).then(res => {
                    event.target.reset()
                    resolve(res.data)
                }).catch(err => {
                    reject(err)
                })
            })
            promise.then(res => {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Сообщение было отправлено!',
                    showConfirmButton: false,
                    timer: 1500
                })
            }).catch(err => {
                if (err.request?.response) {
                    let server_errors = JSON.parse(err.request.response)
                    if (server_errors.errors) {
                        err_block.innerHTML = ''
                        if (server_errors.errors.body) {
                            let p = document.createElement('p')
                            p.innerText = 'Необходимо заполнить Текст сообщения'
                            err_block.append(p)
                        }
                        if (server_errors.errors.title) {
                            let p = document.createElement('p')
                            p.innerText = 'Необходимо заполнить Тему сообщения'
                            err_block.append(p)
                        }
                        err_block.classList.remove('d-none')
                    }
                }
            })
        }
        goMsg.addEventListener('submit', submitForm)
    </script>
</div>
