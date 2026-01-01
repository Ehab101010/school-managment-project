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

 
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("editModal");
    const closeModalBtn = document.getElementById("closeModal");
    const editButtons = document.querySelectorAll(".btn.edit");

    editButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            modal.style.display = "flex";  
        });
    });

    closeModalBtn.addEventListener("click", () => {
        modal.style.display = "none"; 
    });

     window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});

function calculateTotal(input) {
    const row = input.closest("tr");
    const inputs = row.querySelectorAll(".grade-input");
    let total = 0;

    inputs.forEach((i) => {
        const value = parseFloat(i.value) || 0;
        total += value;
    });

    row.querySelector(".total-cell").textContent = total;
}

 
document.getElementById("classSelect").addEventListener("change", function () {
    let classId = this.value;

    fetch(`/teacher/get-sections/${classId}`)
        .then((res) => res.json())
        .then((data) => {
            let sectionSelect = document.getElementById("sectionSelect");
            sectionSelect.innerHTML = '<option value="">اختر الشعبة</option>';

            data.forEach((section) => {
                sectionSelect.innerHTML += `
                    <option value="${section.section_id}">${section.section_type}</option>
                `;
            });
        });
});

 document
    .getElementById("sectionSelect")
    .addEventListener("change", function () {
        let classId = document.getElementById("classSelect").value;
        let sectionId = this.value;

        fetch(`/teacher/get-subjects/${classId}/${sectionId}`)
            .then((res) => res.json())
            .then((data) => {
                let subjectSelect = document.getElementById("subjectSelect");
                subjectSelect.innerHTML =
                    '<option value="">اختر المادة</option>';

                if (data.status === "empty") {
                    subjectSelect.innerHTML =
                        '<option value="">لا يوجد مواد</option>';
                    return;
                }

                data.forEach((sub) => {
                    subjectSelect.innerHTML += `
                    <option value="${sub.subject_id}">${sub.subject_name}</option>
                `;
                });
            });
    });

 document.getElementById("loadStudents").addEventListener("click", function () {
    let classId = document.getElementById("classSelect").value;
    let sectionId = document.getElementById("sectionSelect").value;
    let subjectId = document.getElementById("subjectSelect").value;

    fetch(`/teacher/get-students/${classId}/${sectionId}/${subjectId}`)
        .then((res) => res.json())
        .then((data) => {
            let tbody = document.querySelector(".grades-input-table tbody");
            tbody.innerHTML = "";

            if (data.status === "empty") {
                tbody.innerHTML = '<tr><td colspan="7">لا يوجد طلاب</td></tr>';
                return;
            }

            let i = 1;
            data.forEach((stu) => {
                tbody.innerHTML += `
                    <tr>
                        <td>${i++}</td>
                        <td>${stu.student_name}</td>
                        <td><input type="number" min="0" max="20" class="grade-input" oninput="calculateTotal(this)"></td>
                        <td><input type="number" min="0" max="20" class="grade-input" oninput="calculateTotal(this)"></td>
                        <td><input type="number" min="0" max="10" class="grade-input" oninput="calculateTotal(this)"></td>
                        <td><input type="number" min="0" max="50" class="grade-input" oninput="calculateTotal(this)"></td>
                        <td class="total-cell">0</td>
                    </tr>
                `;
            });
        });
});
