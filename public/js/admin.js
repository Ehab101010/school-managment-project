document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".menu-btn");

    buttons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const parent = btn.parentElement;

             document.querySelectorAll(".menu-item.open").forEach((item) => {
                if (item !== parent) item.classList.remove("open");
            });

             parent.classList.toggle("open");
        });
    });
});

function closeModal() {
    document.getElementById("editModal").style.display = "none";
}

function openEditModal(id) {
    fetch(`/admin/students/get/${id}`)
        .then((res) => res.json())
        .then((student) => {
            document.getElementById("full_name").value = student.full_name;
            document.getElementById("mother_name").value = student.mother_name;
            document.getElementById("birth_date").value = student.birth_date;
            document.getElementById("gender").value = student.gender;
            document.getElementById("nationality").value = student.nationality;
            document.getElementById("student_phone_number").value =
                student.student_phone_number;
            document.getElementById("father_phone_number").value =
                student.father_phone_number;
            document.getElementById("mother_phone_number").value =
                student.mother_phone_number;
            document.getElementById("notes").value = student.notes;

            document.getElementById(
                "editForm"
            ).action = `/admin/students/update/${id}`;
            document.getElementById("editModal").style.display = "flex";
        });
}

 function closeTeacherModal() {
    document.getElementById("teacherModal").style.display = "none";
}

 function openTeacherModal(id) {
    fetch(`/admin/teachers/get/${id}`)
        .then((res) => {
            if (!res.ok) throw new Error("فشل في جلب البيانات");
            return res.json();
        })
        .then((teacher) => {
            document.getElementById("t_full_name").value = teacher.full_name;
            document.getElementById("t_mother_name").value =
                teacher.mother_name;
            document.getElementById("t_birth_date").value = teacher.birth_date;
            document.getElementById("t_gender").value = teacher.gender;
            document.getElementById("t_nationality").value =
                teacher.nationality;
            document.getElementById("t_subject").value = teacher.subject;
            document.getElementById("t_address").value = teacher.address;
            document.getElementById("t_phone").value = teacher.phone;
            document.getElementById("t_email").value = teacher.email;
            document.getElementById("t_notes").value = teacher.notes;

             document.getElementById(
                "teacherForm"
            ).action = `/admin/teachers/update/${id}`;

             document.getElementById("teacherModal").style.display = "flex";
        })
        .catch(() => alert("فشل في جلب بيانات المعلم"));
}

document.getElementById("content-type").addEventListener("change", function () {
    let type = this.value;

    document.getElementById("file-input").style.display = "none";
    document.getElementById("link-input").style.display = "none";

    if (type === "pdf_excel") {
        document.getElementById("file-input").style.display = "block";
    }
    if (type === "video" || type === "link") {
        document.getElementById("link-input").style.display = "block";
    }
});

document.getElementById("content-type").addEventListener("change", function () {
    let type = this.value;

    document.getElementById("file-input").style.display = "none";
    document.getElementById("link-input").style.display = "none";

    if (type === "pdf_excel") {
        document.getElementById("file-input").style.display = "block";
    }
    if (type === "video" || type === "link") {
        document.getElementById("link-input").style.display = "block";
    }
});

 