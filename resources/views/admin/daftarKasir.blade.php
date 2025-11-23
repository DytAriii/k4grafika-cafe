@extends('admin')

@section('content')

<link rel="stylesheet" href="{{ asset('css/daftarkasir.css') }}">

<div class="kasir-management">
    <!-- Controls: Search dan Tombol Tambah -->
    <div class="kasir-controls">
        <div class="controls-left">
            <div class="search-box">
                <input type="text" id="searchKasir" placeholder="Cari kasir..." class="search-input">
                <button type="button" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="controls-right">
            <button class="btn btn-add" onclick="openModal()">
                <i class="fas fa-plus"></i>
                Tambah Kasir
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-container">
            <table class="kasir-table">
                <thead>
                    <tr>
                        <th class="column-no">No</th>
                        <th class="column-username">Username</th>
                        <th class="column-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $usr)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="username-cell">{{ $usr->username }}</td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <button class="btn-edit" 
                                        onclick="openEditModal('{{ $usr->id }}', '{{ $usr->username }}')">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </button>
                                <form action="{{ route('kasir.delete', $usr->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kasir ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Empty State -->
    @if($users->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">👤</div>
        <h3>Belum Ada Kasir</h3>
        <p>Tambahkan kasir pertama untuk mulai mengelola</p>
        <button class="btn-primary" onclick="openModal()">
            <span class="btn-icon">+</span>
            Tambah Kasir Pertama
        </button>
    </div>
    @endif
</div>

<!-- Modal Tambah Kasir -->
<div id="modalKasir" class="modal">
    <div class="modal-backdrop" onclick="closeModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Tambah Kasir Baru</h2>
            <button class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form method="POST" action="{{ route('kasir.store') }}" class="modal-form">
            @csrf
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-input" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="password-icon"></i>
                    </button>
                </div>
            </div>

            @if($roles)
            <input type="hidden" name="roles_id" value="{{ $roles->id }}">
            @endif

            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-primary">
                    <span class="btn-icon">✓</span>
                    Simpan Kasir
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kasir -->
<div id="modalEditKasir" class="modal">
    <div class="modal-backdrop" onclick="closeEditModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Edit Data Kasir</h2>
            <button class="modal-close" onclick="closeEditModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="editKasirForm" method="POST" class="modal-form">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="edit_username" class="form-label">Username</label>
                <input type="text" id="edit_username" name="username" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="edit_password" class="form-label">Password Baru</label>
                <div class="input-wrapper">
                    <input type="password" id="edit_password" name="password" class="form-input" placeholder="Kosongkan jika tidak diubah">
                    <button type="button" class="password-toggle" onclick="togglePassword('edit_password')">
                        <i class="fas fa-eye" id="edit_password-icon"></i>
                    </button>
                </div>
            </div>

            @if($roles)
            <input type="hidden" name="roles_id" value="{{ $roles->id }}">
            @endif

            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-primary">
                    <span class="btn-icon">✓</span>
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<div id="toastNotification" class="toast-notification success">
    {{ session('success') }}
    <span class="close-btn" onclick="document.getElementById('toastNotification').style.display='none'">&times;</span>
</div>
@endif

@if(session('error'))
<div id="toastNotification" class="toast-notification error">
    {{ session('error') }}
    <span class="close-btn" onclick="document.getElementById('toastNotification').style.display='none'">&times;</span>
</div>
@endif

<script>
// Modal Functions
const topbar = document.querySelector('.topbar');

// Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchKasir');
    const tableBody = document.querySelector('.kasir-table tbody');
    const rows = tableBody.querySelectorAll('tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        rows.forEach(row => {
            const username = row.cells[1].textContent.toLowerCase();
            
            if (username.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Update numbering
        let visibleIndex = 1;
        rows.forEach(row => {
            if (row.style.display !== 'none') {
                row.cells[0].textContent = visibleIndex++;
            }
        });
    });
});

function openModal() {
    document.getElementById('modalKasir').style.display = 'block';
    document.body.style.overflow = 'hidden';
    if (topbar) {
        topbar.style.zIndex = "900";
    }
}

function closeModal() {
    document.getElementById('modalKasir').style.display = 'none';
    document.body.style.overflow = 'auto';
    if (topbar) {
        topbar.style.zIndex = "1000";
    }
}

function openEditModal(id, username) {
    const modal = document.getElementById('modalEditKasir');
    const form = document.getElementById('editKasirForm');
    
    // Set form action
    form.action = `/admin/${id}/update`;
    
    // Fill form data
    document.getElementById('edit_username').value = username;
    document.getElementById('edit_password').value = "";
    
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    if (topbar) {
        topbar.style.zIndex = "900";
    }
}

function closeEditModal() {
    document.getElementById('modalEditKasir').style.display = 'none';
    document.body.style.overflow = 'auto';
    if (topbar) {
        topbar.style.zIndex = "1000";
    }
}

// Password Toggle Function
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '-icon');
    
    if (input.getAttribute('type') === 'password') {
        input.setAttribute('type', 'text');
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.setAttribute('type', 'password');
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (modal.style.display === 'block') {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    }
});

// Toast notification
function showToast() {
    const toast = document.getElementById('toastNotification');
    if (toast) {
        // Tampilkan toast
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);

        // Sembunyikan dan hapus setelah 5 detik
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.style.display = 'none';
            }, 500);
        }, 5000);
    }
}

// Panggil fungsi setelah DOM dimuat
showToast();
</script>
@endsection