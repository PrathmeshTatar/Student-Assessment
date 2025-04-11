document.getElementById('assessmentForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const attendance = document.getElementById('attendance').value;
    const unitTest = document.getElementById('unitTest').value;
    const achievements = document.getElementById('achievements').value;
    const mockPractical = document.getElementById('mockPractical').value;

    const data = {
        name,
        attendance,
        unitTest,
        achievements,
        mockPractical
    };

    fetch('submit.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // This shows success message in popup
        document.getElementById('result').innerText = data.message;
    })
    .catch(error => {
        console.error('Error:', error);
        alert("There was an error submitting the form.");
    });
});
