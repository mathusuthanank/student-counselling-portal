document.addEventListener('DOMContentLoaded', function() {
    populateStaffOptions('mentor_id');
    populateStudentOptions('mentee_id');
    populateStaffOptions('tutor_id');
    populateStudentOptions('student_ids');
    populateStaffOptions('mentor_id_single');
    populateStudentOptions('mentee_id_single');
    populateStaffOptions('tutor_id_single');
    populateStudentOptions('student_id_single');
});

function populateStaffOptions(selectId) {
    fetch('getStaff.php')
        .then(response => response.json())
        .then(data => {
            const staffSelect = document.getElementById(selectId);
            staffSelect.innerHTML = ''; // Clear existing options
            data.forEach(staff => {
                const option = document.createElement('option');
                option.value = staff.id;
                option.textContent = staff.username;
                staffSelect.appendChild(option);
            });
        });
}

function populateStudentOptions(selectId) {
    fetch('getStudents.php')
        .then(response => response.json())
        .then(data => {
            const studentSelect = document.getElementById(selectId);
            studentSelect.innerHTML = ''; // Clear existing options
            data.forEach(student => {
                const option = document.createElement('option');
                option.value = student.id;
                option.textContent = student.username;
                studentSelect.appendChild(option);
            });
        });
}

function validateForm() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var userType = document.getElementById('user_type').value;

    if (username == "" || password == "" || userType == "") {
        alert("All fields must be filled out");
        return false;
    }
    return true;
}
