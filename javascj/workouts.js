function goToWorkout() {
    const workout = document.getElementById("workoutInput").value.trim();
    const section = document.querySelector(`.${workout}`);
    if (section) {
        section.scrollIntoView({ behavior: "smooth" });
    } else {
        alert("Workout not found! Please select a valid option.");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const bmiForm = document.getElementById("bmiForm");
    const bmiResult = document.getElementById("bmiResult");

    bmiForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const weight = parseFloat(document.getElementById("bmiWeight").value);
        const height = parseFloat(document.getElementById("bmiHeight").value);

        if (weight > 0 && height > 0) {
            const bmi = (weight / (height * height)).toFixed(2);

            let category = "";
            if (bmi < 18.5) {
                category = "Underweight";
            } else if (bmi >= 18.5 && bmi <= 24.9) {
                category = "Normal weight";
            } else if (bmi >= 25 && bmi <= 29.9) {
                category = "Overweight";
            } else {
                category = "Obesity";
            }

            bmiResult.textContent = `Your BMI is ${bmi} (${category}).`;
        } else {
            bmiResult.textContent = "Please enter valid weight and height.";
            bmiResult.style.color = "red";
        }
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {
            $('#scrollTopBtn').fadeIn();
        } else {
            $('#scrollTopBtn').fadeOut();
        }
    });

    $('#scrollTopBtn').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 300);
    });
});