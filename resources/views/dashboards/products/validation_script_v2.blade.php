@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('scripts')
{{-- Form Validation --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    let croppieInstance = new Croppie(document.getElementById('image-preview'), {
        viewport: {
            width: 320,
            height: 320, // 1:1
            type: 'square'
        },
        boundary: {
            width: 400,
            height: 400
        },
        enableExif: true
    });

    const allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    const maxSize = 2 * (1024 * 1024); // 2MB

    document.getElementById('image').addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (!file) return;

        // Validasi ukuran
        if (file.size > maxSize) {
            alert('Ukuran gambar maksimal 2MB');
            e.target.value = '';
            return;
        }

        // Validasi ekstensi
        const extension = file.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(extension)) {
            alert('Format gambar harus JPG, JPEG, PNG, atau WEBP');
            e.target.value = '';
            return;
        }
        // check if file is an image and is already selected, if not then return
        // Load ke croppie
        const reader = new FileReader();
        reader.onload = function (event) {
            const cropperContainer = document.getElementById('cropperContainer');
            cropperContainer.style.display = 'block';
            croppieInstance.bind({
                url: event.target.result
            });
        };
        reader.readAsDataURL(file);
    });
</script>
<script>
    document.getElementById('product-form').addEventListener('submit', function (event) {
        event.preventDefault();

        const name = document.getElementById('name');
        const description = document.getElementById('description');
        const price = document.getElementById('price');
        const stock = document.getElementById('stock');
        const category = document.getElementById('category_id');

        // if (name.value.trim() === '') {
        //     alert('Name is required.');
        //     name.focus();
        //     return;
        // }

        // if (description.value.trim() === '') {
        //     alert('Description is required.');
        //     description.focus();
        //     return;
        // }

        // if (price.value.trim() === '' || isNaN(price.value) || Number(price.value) < 0) {
        //     alert('Price must be a non-negative number.');
        //     price.focus();
        //     return;
        // }

        // if (stock.value.trim() === '' || isNaN(stock.value) || Number(stock.value) < 0) {
        //     alert('Stock must be a non-negative number.');
        //     stock.focus();
        //     return;
        // }

        // if (category.value === '') {
        //     alert('Category is required.');
        //     category.focus();
        //     return;
        // }

        croppieInstance.result({
            type: 'base64',
            size: { width: 1280, height: 1280 },
            format: 'webp',
            quality: 90
        }).then(function (base64) {

            // Estimasi ukuran base64
            const sizeInBytes = (base64.length * 3) / 4;
            if (sizeInBytes > maxSize) {
                alert('Hasil gambar melebihi 2MB, kurangi kualitas');
                return;
            }
            
            document.getElementById('cropped_image').value = base64;
            event.target.submit();
        });
    });
</script>
@endpush