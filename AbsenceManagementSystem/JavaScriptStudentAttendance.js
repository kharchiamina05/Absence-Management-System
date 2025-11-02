function calculate() {
    const rows = document.querySelectorAll("table tr");
    for (let i = 2; i < rows.length; i++) {
        const row = rows[i];
        const checkboxes = row.querySelectorAll("input[type='checkbox']");
        let absences = 0;
        let participations = 0;

        for (let j = 0; j < checkboxes.length; j += 2) {
            const present = checkboxes[j].checked;
            const participated = checkboxes[j + 1].checked;

            if (!present) absences++;
            if (participated) participations++;
        }

        row.cells[14].textContent = absences;
        row.cells[15].textContent = participations;

        if (absences < 3) {
            row.style.backgroundColor = "green";
            row.cells[16].textContent = "Good attendance - Excellent participation";
        } else if (absences >= 3 && absences <= 4) {
            row.style.backgroundColor = "yellow";
            row.cells[16].textContent = "Warning - attendance low - You need to participate more";
        } else {
            row.style.backgroundColor = "red";
            row.cells[16].textContent = "Excluded - too many absences - You need to participate more";
        }
    }
}

document.getElementById("showReportBtn").addEventListener("click", function () {
    const rows = document.querySelectorAll("#attendanceTable tr");
    let totalStudents = rows.length - 2; 
    let totalPresent = 0;
    let totalParticipation = 0;

    for (let i = 2; i < rows.length; i++) {
        const row = rows[i];
        const checkboxes = row.querySelectorAll("input[type='checkbox']");

        for (let j = 0; j < checkboxes.length; j += 2) {
            if (checkboxes[j].checked) totalPresent++;
            if (checkboxes[j + 1].checked) totalParticipation++;
        }
    }

    document.getElementById("reportSection").style.display = "block";
    document.getElementById("totalStudents").textContent = "Total Students: " + totalStudents;
    document.getElementById("totalPresent").textContent = "Total times marked Present: " + totalPresent;
    document.getElementById("totalParticipation").textContent = "Total Participation marks: " + totalParticipation;

    if (window.attendanceChartInstance) {
        window.attendanceChartInstance.destroy();
    }

    const ctx = document.getElementById('attendanceChart').getContext('2d');
    window.attendanceChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Total Students", "Present Count", "Participation Count"],
            datasets: [{
                label: 'Attendance Report',
                data: [totalStudents, totalPresent, totalParticipation],
            }]
        }
    });
});

window.onload = function() {
    let students = JSON.parse(localStorage.getItem("students")) || [];
    const table = document.getElementById("attendanceTable");

    students.forEach(student => {
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td>${student.lastName}</td>
            <td>${student.firstName}</td>
            <td><input type="checkbox"></td><td><input type="checkbox"></td>
            <td><input type="checkbox"></td><td><input type="checkbox"></td>
            <td><input type="checkbox"></td><td><input type="checkbox"></td>
            <td><input type="checkbox"></td><td><input type="checkbox"></td>
            <td><input type="checkbox"></td><td><input type="checkbox"></td>
            <td><input type="checkbox"></td><td><input type="checkbox"></td>
            <td class="abs">0</td>
            <td class="par">0</td>
            <td class="msg"><input type="text" readonly></td>
        `;
        table.appendChild(newRow);
    });
};

$(document).ready(function() {

    $("#attendanceTable tr").hover(
        function() {
            $(this).addClass("rowHover");
        },
        function() {
            $(this).removeClass("rowHover");
        }
    );

    $("#attendanceTable tr").click(function() {

        const cells = $(this).find("td");

        if (cells.length > 0) {
            const lastName = cells.eq(0).text();
            const firstName = cells.eq(1).text();
            const absences = cells.eq(14).text();

            alert("Student: " + firstName + " " + lastName + "\nAbsences: " + absences);
        }
    });
    $("#highlightBest").click(function() {
        $("#attendanceTable tbody tr").each(function() {
            let absences = parseInt($(this).find(".absences").text());

            if (absences < 3) {
                $(this)
                    .css("background-color", "#d4edda")
                    .fadeOut(300)
                    .fadeIn(300)
                    .fadeOut(300)
                    .fadeIn(300);
            }
        });
    });

    $("#resetColors").click(function() {
        $("#attendanceTable tbody tr").css("background-color", "");
    });

});