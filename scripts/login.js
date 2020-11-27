const login = document.getElementById('signup-btn')
const username = document.getElementById('username');
const password = document.getElementById('password');
var base_url = document.getElementById('base_url').innerHTML;

function setErrorFor(input, message) {
    const formControl = input.parentElement;
    const small = formControl.querySelector('small');
    formControl.className = 'form-control error';
    small.innerText = message;
}


function checkInputs() {
    const usernameValue = username.value.trim();
    const passwordValue = password.value.trim();

    if (usernameValue === '') {
        setErrorFor(username, 'Username is blank');
        return 0;
    }

    if (passwordValue === '') {
        setErrorFor(password, 'Password is blank');
        return 0;
    }

    return 1;
}

async function postData(url, data) {
    return fetch(url, {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        redirect: 'follow',
        referrer: 'no-referrer',
        body: data,
    }).then(response => response.json());
}

login.addEventListener('click', e => {
    e.preventDefault();
    if (checkInputs()) {
        const usernameValue = username.value.trim();
        const passwordValue = password.value.trim();

        const formData = new FormData();
        formData.append('user_id', usernameValue);
        formData.append('pass', passwordValue);

        postData(base_url + '/login', formData)
            .then(data => {
                var authStatus = data['status'];
                if (authStatus == 0) {
                    const formControl = login.parentElement;
                    const small = formControl.querySelector('small');
                    small.innerText = "Invalid Credentials";
                    formControl.querySelector('.reg-success').style.visibility = 'visible';

                } else {
                    window.location.replace(base_url + '/');
                }
            });
    }
});