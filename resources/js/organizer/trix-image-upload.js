
let pendingUploads = new Set();
let uploadFailed = false;
let allowFormSubmit = false;

// Handle image uploads from Trix
document.addEventListener('trix-attachment-add', function (event) {
    const attachment = event.attachment;

    if (!attachment.file || !attachment.file.type.startsWith('image/')) {
        return;
    }

    const formData = new FormData();
    formData.append('attachment', attachment.file);

    let uploadPromise;

    uploadPromise = (async () => {
        try {
            const response = await fetch(window.trixImageUploadUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (!response.ok) {
                throw new Error('Image upload failed');
            }

            const data = await response.json();

            attachment.setAttributes({
                url: data.url,
                href: data.url
            });

            return true;

        } catch (error) {
            console.error(error);
            uploadFailed = true;
            return false;

        } finally {
            pendingUploads.delete(uploadPromise);
        }
    })();

    pendingUploads.add(uploadPromise);
});


// Prevent event form submission while images are uploading
document.addEventListener('submit', async function (event) {
    const form = event.target;

    // Only handle forms containing a Trix editor
    if (!form.querySelector('trix-editor')) {
        return;
    }

    // Allow the form to submit after uploads finish
    if (allowFormSubmit) {
        allowFormSubmit = false;
        return;
    }

    event.preventDefault();

    const submitButton = event.submitter;
    if (submitButton) {
        submitButton.disabled = true;
    }

    // Wait until all pending uploads finish
    while (pendingUploads.size > 0) {
        await Promise.all([...pendingUploads]);
    }

    // Stop submission if any image upload failed
    if (uploadFailed) {
        alert('An image could not be uploaded. Please remove it or try again before creating the event.');

        if (submitButton) {
            submitButton.disabled = false;
        }

        return;
    }

    // All uploads successful: submit the form
    if (submitButton) {
        submitButton.disabled = false;
    }

    allowFormSubmit = true;

    if (submitButton) {
        form.requestSubmit(submitButton);
    } else {
        form.requestSubmit();
    }
});
