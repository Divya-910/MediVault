<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doctor Recommendation System</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Find a Doctor</h1>
  <form id="doctorForm">
    <label for="specialization">Specialization:</label>
    <select id="specialization">
      <option value="Cardiologist">Cardiologist</option>
      <option value="Dermatologist">Dermatologist</option>
      <!-- Add more options -->
    </select>
    <label for="location">Location:</label>
    <select id="location">
      <option value="New York">New York</option>
      <option value="Los Angeles">Los Angeles</option>
      <!-- Add more options -->
    </select>
    <button type="submit">Find Doctors</button>
  </form>
  <div id="doctorList"></div>
  <script src="script.js"></script>
</body>
</html>
<!-- <script>
  document.getElementById('doctorForm').addEventListener('submit', function(e) {
  e.preventDefault();
  let specialization = document.getElementById('specialization').value;
  let location = document.getElementById('location').value;
  fetchDoctors(specialization, location);
});

function fetchDoctors(specialization, location) {
  fetch('recommendation.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ specialization, location }),
  })
  .then(response => response.json())
  .then(data => {
    displayDoctors(data);
  })
  .catch(error => console.error('Error:', error));
}

function displayDoctors(doctors) {
  let doctorList = document.getElementById('doctorList');
  doctorList.innerHTML = '';
  doctors.forEach(doctor => {
    let doctorCard = document.createElement('div');
    doctorCard.classList.add('doctor-card');
    doctorCard.innerHTML = `
      <h2>${doctor.name}</h2>
      <p>Specialization: ${doctor.specialization}</p>
      <p>Location: ${doctor.location}</p>
      <p>Ratings: ${doctor.rating}</p>
    `;
    doctorList.appendChild(doctorCard);
  });
}
</script> -->