let url;
let page = 1;
let pagemax = null;
let accessToken = null;

const metaTag = document.querySelector('meta[name="csrf-token"]');
const csrfToken = metaTag ? metaTag.getAttribute("content") : null;

const formsContainer = document.getElementById("formsContainer");

const inputGroup = `
    <div class="input-group">
        <input type="text" id="idObj" class="form-control" placeholder="Введите Id">
        <button id="apiId" class="btn btn-secondary" type="button" onclick="handleId();">Ок</button>
    </div>
`;

const formLogin = `
<div class="login-group">
    <form method="post">
        <input class="border-gray-300 rounded-md" id="email" type="email" name="email" required="required">
        <input class="border-gray-300 rounded-md mt-4" id="pass" type="password" name="password" required="required">
        <div class="flex items-center justify-end mt-4">
            <button type="button" class="px-4 py-2 rounded-md font-semibold text-xs text-white ml-3" id="login" onclick="myLogin('/api/login', this);">Login</button>
        </div>
    </form>
</div>
`;

const formAuthor = `
<div class="updateAuthor">
    <form method="post" >
        <div>
            <input class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" id="nickname" name="nickname" type="text" placeholder="Псевдоним">
        </div>
        <div>
            <input class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" id="full_name" name="full_name" type="text" placeholder="Полное имя">
        </div>
        <div>
            <input class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" id="date_birth" name="date_birth" type="date">
        </div>
        <div>
            <input class="border-gray-300 rounded-md shadow-sm mt-1 block w-full" id="biography" name="biography" type="text" placeholder="Биография">
        </div>
        <div class="flex items-center justify-end mt-4">
            <button type="button" class="px-4 py-2 rounded-md font-semibold text-xs text-white ml-3" id="login" onclick="actionFetch('/api/author/update', this);">Login</button>
        </div>
    </form>
</div>
`;

const formBook = `
<div class="updateBook">
<form method="post" class="mt-6 space-y-6">
    <input class="border-gray-300 rounded-md" id="id" name="id" type="text" placeholder="Id книги" required="required">
    <input class="border-gray-300 rounded-md" id="name" name="name" type="text" placeholder="Название" required="required">
    <input class="border-gray-300 rounded-md" id="description" name="description" type="text" placeholder="Описание" required="required">
    <div>
        <label class="font-medium text-sm text-gray-700" for="genre">Жанр</label>
        <select class="border-gray-300 rounded-md mt-1 w-full" name="genre[]" multiple="multiple">
        <option value="1">Жанр 1</option>
            <option value="2">Жанр 2</option>
            <option value="3">Жанр 3</option>
            <option value="4">Жанр 4</option>
            <option value="5">Жанр 5</option>
        </select>
    </div>
    <div>
        <label class="block font-medium text-sm text-gray-700" for="type">Тип издания</label>
        <select class="border-gray-300 rounded-md shadow-sm mt-1 w-full" name="type" value="Печатное издание">
            <option value="Графическое издание">Графическое издание</option>
            <option value="Цифровое издание">Цифровое издание</option>
            <option value="Печатное издание" selected="">Печатное издание</option>
        </select>
    </div>
    <div>
        <label class="block font-medium text-sm text-gray-700" for="publish_date">Дата выхода</label>
        <input class="border-gray-300 rounded-md shadow-sm mt-1 w-full" id="publish_date" name="publish_date" type="date" required="required">
    </div>
    <div class="flex items-center justify-end mt-4">
        <button type="button" class="px-4 py-2 rounded-md font-semibold text-xs text-white ml-3" id="login" onclick="actionFetch('/api/book/update', this);">Save</button>
    </div>
</form>
</div>
`;

// Обработчик для разных действий
function handleAction(event) {
    formsContainer.innerHTML = "";
    writeToIframe('');

    var displayValue = (event.target.id == 'books' || event.target.id == 'authors' || event.target.id == 'genres' || event.target.id == 'prev' || event.target.id == 'next') ? 'block' : 'none';
    document.getElementById('prev').style.display = displayValue;
    document.getElementById('next').style.display = displayValue;    

    if(!accessToken && (event.target.id == 'delBook' || event.target.id == 'formAuthor' || event.target.id == 'formBook') ) {
        alert('Сначала отправьте запрос авторизации');
        return;
    }

    switch (event.target.id) {
        case 'books':
            page = 1;
            url = '/api/books';
            break;
        case 'authors':
            page = 1;
            url = '/api/authors';
            break;
        case 'genres':
            page = 1;
            url = '/api/genres';
            break;
        case 'getBook':
            url = '/api/book';
            formsContainer.insertAdjacentHTML("beforeend", inputGroup);
            return;
        case 'getAuthor':
            url = '/api/author';
            formsContainer.insertAdjacentHTML("beforeend", inputGroup);
            return;
        case 'delBook':
            url = '/api/book/delBook';
            formsContainer.insertAdjacentHTML("beforeend", inputGroup);            
            return;
        case 'formLogin':
            formsContainer.insertAdjacentHTML("beforeend", formLogin);
            return;
        case 'formAuthor':
            formsContainer.insertAdjacentHTML("beforeend", formAuthor);
            return;
        case 'formBook':
            formsContainer.insertAdjacentHTML("beforeend", formBook);
            return;
        case 'login':
            let email = document.getElementById('email').value;
            let pass = document.getElementById('pass').value;
            myLogin(url, email, pass);
            return;

        case 'prev':
            page = (page > 1) ? page - 1 : 1;
            break;
        case 'next':
            if (pagemax == null || page != pagemax) page++;
            break;
        default:
            // Действие по умолчанию, если элемент не определен
            return;
    }

    myFetch(url, page);
}

function handleId() {
    let id = document.getElementById('idObj').value;
    switch (url) {
        case '/api/book':
            myFetch(url, id);
        break;
        case '/api/author':
            myFetch(url, id);
        break;
        case '/api/book/delBook':
            delBook(id);
        break;
        default:
            return;
    }
}
// Назначение обработчика для всех элементов
document.getElementById('books').addEventListener('click', handleAction);
document.getElementById('authors').addEventListener('click', handleAction);
document.getElementById('genres').addEventListener('click', handleAction);
document.getElementById('getBook').addEventListener('click', handleAction);
document.getElementById('getAuthor').addEventListener('click', handleAction);
document.getElementById('delBook').addEventListener('click', handleAction);
document.getElementById('formLogin').addEventListener('click', handleAction);
document.getElementById('formAuthor').addEventListener('click', handleAction);
document.getElementById('formBook').addEventListener('click', handleAction);
document.getElementById('prev').addEventListener('click', handleAction);
document.getElementById('next').addEventListener('click', handleAction);

function myFetch(url, page) {
    fetch(url+'/'+page).then(response => response.json())
    .then(data => {
        if(data.data) {
            var beautyJson = JSON.stringify(data.data, null, 2);
            if( data.data.length == 0) pagemax = page;
        } else {
            var beautyJson = JSON.stringify(data, null, 2);
        }

        writeToIframe(beautyJson);
    })
    .catch(error => {
        console.error('Произошла ошибка:', error);
    });
}

function myLogin(url, button) {
    var form = button.closest('form');
    var formData = new FormData(form);

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        var beautyJson = JSON.stringify(data, null, 2);
        accessToken = data.access_token;
        writeToIframe(beautyJson);
    })
    .catch(error => {
        console.error('Произошла ошибка:', error);
    });
}

function delBook(idBook) {
    var formData = new FormData();
    formData.append('id', idBook);

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Authorization': 'Bearer ' + accessToken,
        }
    })
    .then(response => response.json())
    .then(data => {
        var beautyJson = JSON.stringify(data, null, 2);
        writeToIframe(beautyJson);
    })
    .catch(error => {
        console.log(error);
    });
}

function actionFetch(url, button) {
    var form = button.closest('form');
    var formData = new FormData(form);

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Authorization': 'Bearer ' + accessToken,
        }
    })
    .then(response => response.json())
    .then(data => {
        var beautyJson = JSON.stringify(data, null, 2);
        writeToIframe(beautyJson);
    })
    .catch(error => {
        console.log(error);
    });
}

// Вставляем отформатированный JSON в <iframe>
function writeToIframe(data) {
    var iframe = document.getElementById('jsonViewer');
    iframe.contentDocument.open();
    iframe.contentDocument.write('<pre>' + data + '</pre>');
    iframe.contentDocument.close();
}