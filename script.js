const form = document.querySelector(".form");

form.addEventListener("submit", async function (event) {
  event.preventDefault();

  const height = Number(document.querySelector("#height").value);
  const weight = Number(document.querySelector("#weight").value);
  const results = document.querySelector("#results");
  const message = document.querySelector("#message");
  const saveStatus = document.querySelector("#save-status");

  saveStatus.textContent = "";

  if (!Number.isFinite(height) || height <= 0) {
    results.textContent = "Please enter a valid height greater than zero.";
    message.textContent = "";
    return;
  }

  if (!Number.isFinite(weight) || weight <= 0) {
    results.textContent = "Please enter a valid weight greater than zero.";
    message.textContent = "";
    return;
  }

  const bmi = weight / ((height / 100) ** 2);
  const roundedBmi = bmi.toFixed(2);
  let category = "Overweight";

  if (bmi < 18.5) {
    category = "Underweight";
  } else if (bmi < 25) {
    category = "Normal";
  }

  results.textContent = roundedBmi;
  message.textContent = category;

  const body = new URLSearchParams({
    height: String(height),
    weight: String(weight),
  });

  try {
    const response = await fetch("save_data.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "Accept": "application/json",
      },
      body,
    });

    const data = await response.json();
    if (!response.ok || !data.success) {
      throw new Error(data.message || "Could not save this calculation.");
    }
    saveStatus.textContent = data.message;
  } catch (error) {
    saveStatus.textContent = error.message || "BMI calculated, but the record could not be saved.";
  }
});
