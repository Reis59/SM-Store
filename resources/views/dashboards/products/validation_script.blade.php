@push('styles')
{{-- cropie css cdn --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@push('scripts')
{{-- cropie js cdn --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // cropie image upload and preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    let croppieInstance;
    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            // validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file.');
                event.target.value = '';
                if (croppieInstance) {
                    croppieInstance.destroy();
                    croppieInstance = null;
                }
                imagePreview.src = '';
                imagePreview.classList.add('hidden');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                if (croppieInstance) {
                    croppieInstance.destroy();
                }
                imagePreview.classList.remove('hidden');
                imagePreview.src = e.target.result;
                croppieInstance = new Croppie(imagePreview, {
                    viewport: { width: 200, height: 200 },
                    boundary: { width: 250, height: 250 },
                    showZoomer: true,
                    enableOrientation: true
                });
            };
            reader.readAsDataURL(file);
        }
    });

    // form validation before submit
    document.getElementById('product-form').addEventListener('submit', function(event) {
        const name = document.getElementById('name');
        const description = document.getElementById('description');
        const price = document.getElementById('price');
        const stock = document.getElementById('stock');
        const category = document.getElementById('category_id');

        if(name.value.trim() === '') {
            name.classList.add('border-red-500');
            alert('Name is required.');
            event.preventDefault();
            return;
        }

        if(description.value.trim() === '') {
            description.classList.add('border-red-500');
            alert('Description is required.');
            event.preventDefault();
            return;
        }

        if (price.value.trim() === '' || isNaN(price.value) || Number(price.value) <= 0) {
            price.classList.add('border-red-500');
            alert('Price must be a valid number greater than zero.');
            event.preventDefault();
            return;
        }

        if (stock.value.trim() === '' || isNaN(stock.value) || Number(stock.value) < 0) {
            stock.classList.add('border-red-500');
            alert('Stock must be a valid number and cannot be negative.');
            event.preventDefault();
            return;
        }

        if(category.value === '') {
            category.classList.add('border-red-500');
            alert('Category is required.');
            event.preventDefault();
            return;
        }

        if (croppieInstance) {
            croppieInstance.result('blob').then(function(blob) {
                const fileInput = document.getElementById('image');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(new File([blob], fileInput.files[0].name, { type: blob.type }));
                fileInput.files = dataTransfer.files;
                event.target.submit();
            });
            event.preventDefault();
        }
    });
</script>
<script>
    // js validation and image preview
    // document.getElementById('image').addEventListener('change', function(event) {
    //     const file = event.target.files[0];
    //     if (file) {
    //         // validate file type
    //         if (!file.type.startsWith('image/')) {
    //             alert('Please select a valid image file.');
    //             event.target.value = '';
    //             const imgPreview = document.getElementById('image-preview');
    //             if (imgPreview) {
    //                 imgPreview.src = '';
    //             }
    //             return;
    //         }
    //         const reader = new FileReader();
    //         reader.onload = function(e) {
    //             const imgPreview = document.getElementById('image-preview');
    //             if (!imgPreview) {
    //                 const img = document.createElement('img');
    //                 img.id = 'image-preview';
    //                 img.src = e.target.result;
    //                 img.classList.add('mt-2', 'max-h-48');
    //                 event.target.parentNode.appendChild(img);
    //             } else {
    //                 imgPreview.classList.remove('hidden');
    //                 imgPreview.src = e.target.result;
    //             }
    //         };
    //         reader.readAsDataURL(file);
    //     }
    // });
</script>
@endpush