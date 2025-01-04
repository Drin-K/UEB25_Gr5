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

document.addEventListener("DOMContentLoaded", () => {
    const calculateBMIButton = document.getElementById("calculateBMI");
    const bmiResult = document.getElementById("bmiResult");

    const users = [];

    function User(name, weight, height, bmi, category) {
        this.name = name;
        this.weight = weight;
        this.height = height;
        this.bmi = bmi;
        this.category = category;
    }

    function calculateBMI(weight, height) {
        if (isNaN(weight) || isNaN(height)) {
            return NaN;
        }
        return (weight / (height * height)).toFixed(2);
    }

    function classifyBMI(bmi) {
        if (isNaN(bmi)) return "Invalid BMI";
        if (bmi < 18.5) return "Underweight";
        else if (bmi >= 18.5 && bmi < 24.9) return "Normal weight";
        else if (bmi >= 25 && bmi < 29.9) return "Overweight";
        else return "Obesity";
    }

    function getHighRiskUsers(users) {
        return users.filter(user => user.category === "Overweight" || user.category === "Obesity");
    }

    calculateBMIButton.addEventListener("click", (e) => {
        e.preventDefault();

        const userName = document.getElementById("userName").value.trim();
        const weightInput = document.getElementById("weight").value;
        const heightInput = document.getElementById("height").value;

        const weight = parseFloat(weightInput);
        const height = parseFloat(heightInput);

        if (weight > Number.MAX_VALUE || height > Number.MAX_VALUE) {
            bmiResult.textContent = "Weight or height is too large to calculate BMI!";
            bmiResult.style.color = "red";
            return;
        }

        if (userName && weight > 0 && height > 0) {
            bmiResult.textContent = "Calculating your BMI...";

            setTimeout(() => {
                const bmiValue = calculateBMI(weight, height);

                if (isNaN(bmiValue)) {
                    bmiResult.textContent = "Error: Unable to calculate BMI. Please check your inputs.";
                    bmiResult.style.color = "red";
                    return;
                }

                const bmiCategory = classifyBMI(bmiValue);

                const user = new User(userName, weight, height, bmiValue, bmiCategory);

                users.push(user);

                bmiResult.textContent = `Hello ${user.name}, your BMI is ${user.bmi} (${user.category}).`;
                console.log("All Users in the Array:");
                console.table(users);

                const highRiskUsers = getHighRiskUsers(users);
                console.log("High-Risk Users:");
                console.table(highRiskUsers);
            }, 2000);
        } else {
            bmiResult.textContent = "Please enter valid inputs.";
            bmiResult.style.color = "red";
        }
    });
});
