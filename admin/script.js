document.getElementById('jobApplicationForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    const applicantData = {
        storeName: formData.get('storeName'),
        photo: formData.get('photo').name,
        jobTitle: formData.get('jobTitle'),
        salary: formData.get('salary'),
        workHours: formData.get('workHours'),
        ownerPhone: formData.get('ownerPhone'),
        details: formData.get('details')
    };

    console.log(applicantData);

    alert('ส่งใบสมัครเรียบร้อยแล้ว!');

    this.reset();
});
