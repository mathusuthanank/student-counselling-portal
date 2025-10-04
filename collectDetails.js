document.addEventListener('DOMContentLoaded', function() {
    const studentDetails = JSON.parse('<?php echo json_encode($studentDetails); ?>');

    for (const [key, value] of Object.entries(studentDetails)) {
        const input = document.querySelector(`[name="${key}"]`);
        if (input) {
            if (input.type === 'radio') {
                const radio = document.querySelector(`[name="${key}"][value="${value}"]`);
                if (radio) {
                    radio.checked = true;
                }
            } else {
                input.value = value;
            }
        }
    }
});
