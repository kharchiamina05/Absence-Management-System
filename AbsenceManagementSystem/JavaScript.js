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
