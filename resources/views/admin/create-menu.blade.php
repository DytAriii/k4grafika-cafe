<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-50: #fdf6f2;
            --primary-100: #f9e5db;
            --primary-200: #f3ccb8;
            --primary-300: #e9a98a;
            --primary-400: #dd7f5c;
            --primary-500: #d15e36;
            --primary-600: #a74c29;
            --primary-700: #8a3d23;
            --primary-800: #723322;
            --primary-900: #612c1f;

            --neutral-50: #f9fafb;
            --neutral-100: #f3f4f6;
            --neutral-200: #e5e7eb;
            --neutral-300: #d1d5db;
            --neutral-400: #9ca3af;
            --neutral-500: #6b7280;
            --neutral-600: #4b5563;
            --neutral-700: #374151;
            --neutral-800: #1f2937;
            --neutral-900: #111827;

            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--neutral-50) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Container utama */
        .container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: modalSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid var(--neutral-200);
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%);
            color: white;
            padding: 24px 28px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .header h1 {
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        .header h1 i {
            font-size: 22px;
        }

        /* Form */
        .form-container {
            padding: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: var(--neutral-700);
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-label i {
            color: var(--primary-500);
            font-size: 14px;
        }

        /* Input & Select */
        .form-input,
        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--neutral-300);
            border-radius: 10px;
            background: white;
            font-size: 14px;
            color: var(--neutral-700);
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary-500);
            box-shadow: 0 0 0 3px var(--primary-100);
        }

        .form-input::placeholder {
            color: var(--neutral-400);
        }

        /* Row dua kolom */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group.hidden {
            display: none;
        }

        /* File Upload */
        .file-upload-wrapper {
            position: relative;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: var(--neutral-50);
            border: 2px dashed var(--neutral-300);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--neutral-600);
            font-size: 14px;
            justify-content: center;
        }

        .file-upload-label:hover {
            border-color: var(--primary-500);
            color: var(--primary-600);
            background: var(--primary-50);
        }

        .file-upload-label i {
            font-size: 16px;
        }

        .file-preview {
            margin-top: 12px;
            text-align: center;
        }

        .file-preview img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 8px;
            border: 1px solid var(--neutral-200);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Current Image Preview */
        .current-image-section {
            margin-bottom: 16px;
            padding: 16px;
            background: var(--neutral-50);
            border-radius: 10px;
            border: 1px solid var(--neutral-200);
        }

        .current-image-label {
            font-size: 13px;
            color: var(--neutral-600);
            margin-bottom: 8px;
            display: block;
            font-weight: 500;
        }

        .image-preview {
            text-align: center;
        }

        .image-preview img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 8px;
            border: 1px solid var(--neutral-200);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Button Group */
        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .btn {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
        }

        .btn-secondary {
            background: var(--neutral-300);
            color: var(--neutral-700);
        }

        .btn-secondary:hover {
            background: var(--neutral-400);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: var(--primary-600);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-700);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(167, 76, 41, 0.3);
        }

        /* Animasi */
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .container {
                max-width: 100%;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .header {
                padding: 20px 24px;
            }
            
            .form-container {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <i class="fas fa-plus"></i>
                Tambah Menu Baru
            </h1>
        </div>
        
        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-utensils"></i>
                    Nama Menu
                </label>
                <input type="text" name="nama" class="form-input" placeholder="Masukkan nama menu" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-tag"></i>
                        Kategori
                    </label>
                    <select name="categories_id" class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama_category }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-tag"></i>
                        Harga
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--neutral-500); font-weight: 500;">Rp</span>
                        <input type="number" name="harga" class="form-input" placeholder="0" style="padding-left: 40px;" required>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-image"></i>
                    Foto Menu
                </label>
                <div class="file-upload-wrapper">
                    <input type="file" name="gambar" id="gambarInput" accept="image/*" required class="file-input">
                    <label for="gambarInput" class="file-upload-label">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Pilih gambar menu</span>
                    </label>
                    <div class="file-preview" id="filePreview"></div>
                </div>
            </div>
            
            <div class="form-group hidden">
                <label class="form-label">Status</label>
                <select name="status_id" class="form-select" required>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="button-group">
                <a href="{{ route('manajemenMenu') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan Menu
                </button>
            </div>
        </form>
    </div>

    <script>
        // File preview functionality
        document.getElementById('gambarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('filePreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" style="max-width: 120px; max-height: 120px; border-radius: 8px; border: 1px solid var(--neutral-200);">
                        <p style="margin-top: 8px; font-size: 12px; color: var(--neutral-500);">Preview gambar</p>
                    `;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });
    </script>
</body>
</html>