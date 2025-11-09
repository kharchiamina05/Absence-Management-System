const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        let isValid = true;

        const studentId = document.getElementById('student_id').value.trim();
        const lastName = document.getElementById('last_name').value.trim();
        const firstName = document.getElementById('first_name').value.trim();
        const email = document.getElementById('email').value.trim();

        document.querySelectorAll('.error-msg').forEach(el => el.remove());

        function showError(input, message) {
            const error = document.createElement('div');
            error.className = 'error-msg';
            error.style.color = 'red';
            error.style.fontSize = '0.9em';
            error.textContent = message;
            input.insertAdjacentElement('afterend', error);
            isValid = false;
    }

    if (studentId === '') {
        showError(document.getElementById('student_id'), 'Student ID is required.');
    } else if (!/^\d+$/.test(studentId)) {
        showError(document.getElementById('student_id'), 'Student ID must contain only numbers.');
    }

    if (lastName === '') {
        showError(document.getElementById('last_name'), 'Last Name is required.');
    } else if (!/^[A-Za-z]+$/.test(lastName)) {
        showError(document.getElementById('last_name'), 'Last Name must contain only letters.');
    }

    if (firstName === '') {
        showError(document.getElementById('first_name'), 'First Name is required.');
    } else if (!/^[A-Za-z]+$/.test(firstName)) {
        showError(document.getElementById('first_name'), 'First Name must contain only letters.');
    }

    if (email === '') {
        showError(document.getElementById('email'), 'Email is required.');
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showError(document.getElementById('email'), 'Invalid email format.');
    }

    if (!isValid) {
        event.preventDefault();
    }
});

form.addEventListener("submit", function(event) {
    event.preventDefault();

    if (document.querySelector(".error-msg")) return;

    const studentId = document.getElementById('student_id').value.trim();
    const lastName = document.getElementById('last_name').value.trim();
    const firstName = document.getElementById('first_name').value.trim();
    const email = document.getElementById('email').value.trim();

    let students = JSON.parse(localStorage.getItem("students")) || [];

    students.push({ studentId, lastName, firstName, email });

    localStorage.setItem("students", JSON.stringify(students));

    const msg = document.getElementById("successMsg");
    msg.textContent = "Student added successfully!";

    form.reset();

    setTimeout(() => {
        msg.textContent = "";
    }, 2000);
});