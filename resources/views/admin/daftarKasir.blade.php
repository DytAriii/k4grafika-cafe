@extends('admin')

@section('content')

<style>
/* ===== VARIABLES ===== */
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

    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --radius-sm: 6px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --radius-xl: 16px;
}

/* ===== BASE STYLES ===== */
.kasir-management {
    padding: 24px;
    padding-top: 80px;
    background: var(--neutral-50);
    min-height: 100vh;
    max-width: 100%;
    margin: 0;
    font-family: 'Poppins', 'Inter', 'Segoe UI', sans-serif;
}

/* ===== HEADER STYLES ===== */
.kasir-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    padding: 20px 0;
}

.header-content {
    flex: 1;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: var(--neutral-800);
    margin: 0 0 8px 0;
    line-height: 1.2;
}

.page-subtitle {
    font-size: 14px;
    color: var(--neutral-600);
    margin: 0;
    font-weight: 400;
}

/* ===== BUTTON STYLES ===== */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: var(--primary-600);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    box-shadow: var(--shadow-sm);
}

.btn-primary:hover {
    background: var(--primary-700);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: var(--neutral-100);
    color: var(--neutral-800);
    border: 1px solid var(--neutral-300);
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-secondary:hover {
    background: var(--neutral-200);
    border-color: var(--neutral-400);
}

.btn-icon {
    font-weight: 600;
    font-size: 16px;
}

/* ===== TABLE STYLES ===== */
.table-section {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    border: 1px solid var(--neutral-200);
}

.table-container {
    overflow-x: auto;
    width: 100%;
}

.kasir-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}

.kasir-table thead {
    background: var(--primary-600);
    position: sticky;
    top: 0;
}

.kasir-table th {
    padding: 16px 20px;
    text-align: left;
    font-size: 14px;
    font-weight: 600;
    color: white;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
}

.kasir-table th:hover {
    background: var(--primary-700) !important;
}

.kasir-table td {
    padding: 16px 20px;
    border-bottom: 1px solid var(--neutral-200);
    font-size: 14px;
    color: var(--neutral-800);
    vertical-align: middle;
}

.kasir-table tr:last-child td {
    border-bottom: none;
}

.kasir-table tr:hover {
    background: var(--neutral-50);
}

/* Column Widths */
.column-no { 
    width: 80px; 
    text-align: center;
}
.column-username { 
    width: auto; 
    min-width: 200px; 
}
.column-actions { 
    width: 200px; 
    text-align: center;
}

.text-center { text-align: center; }
.username-cell { 
    font-weight: 500; 
    color: var(--neutral-800);
}

/* ===== ACTION BUTTONS ===== */
.actions-cell {
    text-align: center;
}

.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
}

.btn-edit, .btn-delete {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px;
    border: none;
    border-radius: var(--radius-sm);
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    min-width: 70px;
    justify-content: center;
}

.btn-edit {
    background: var(--primary-500);
    color: white;
}

.btn-edit:hover {
    background: var(--primary-600);
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.btn-delete {
    background: var(--danger);
    color: white;
}

.btn-delete:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

/* ===== EMPTY STATE ===== */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--neutral-200);
}

.empty-icon {
    font-size: 64px;
    margin-bottom: 16px;
    opacity: 0.6;
}

.empty-state h3 {
    font-size: 20px;
    font-weight: 600;
    color: var(--neutral-800);
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 14px;
    color: var(--neutral-600);
    margin: 0 0 24px 0;
}

/* ===== MODAL STYLES ===== */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
}

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.modal-content {
    position: relative;
    background: white;
    margin: 40px auto;
    border-radius: var(--radius-xl);
    width: 90%;
    max-width: 440px;
    box-shadow: var(--shadow-lg);
    animation: modalSlideIn 0.3s ease-out;
    border: 1px solid var(--neutral-200);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 24px 0 24px;
    border-bottom: 1px solid var(--neutral-200);
    padding-bottom: 20px;
}

.modal-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--neutral-800);
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    color: var(--neutral-500);
    cursor: pointer;
    padding: 8px;
    border-radius: var(--radius-sm);
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-close:hover {
    background: var(--neutral-100);
    color: var(--neutral-700);
}

.modal-form {
    padding: 24px;
}

/* ===== FORM STYLES ===== */
.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: var(--neutral-700);
    margin-bottom: 8px;
}

.input-wrapper {
    position: relative;
    width: 100%;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--neutral-300);
    border-radius: var(--radius-md);
    font-size: 14px;
    transition: all 0.2s ease;
    background: white;
    font-family: inherit;
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-500);
    box-shadow: 0 0 0 3px var(--primary-100);
}

.form-input::placeholder {
    color: var(--neutral-400);
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--neutral-500);
    cursor: pointer;
    padding: 4px;
    border-radius: var(--radius-sm);
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.password-toggle:hover {
    color: var(--neutral-700);
    background: var(--neutral-100);
}

.modal-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid var(--neutral-200);
}

/* ===== ANIMATIONS ===== */
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

/* ===== TOAST/ALERT STYLES ===== */
.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1100;
    padding: 15px 20px;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-lg);
    font-weight: 500;
    font-size: 14px;
    opacity: 0;
    transform: translateX(100%);
    transition: all 0.5s ease-in-out;
}

.toast-notification.show {
    opacity: 1;
    transform: translateX(0);
}

.toast-notification.success {
    background-color: var(--success);
    color: white;
}

.toast-notification.error {
    background-color: var(--danger);
    color: white;
}

.toast-notification .close-btn {
    margin-left: 10px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 16px;
    line-height: 1;
    cursor: pointer;
    transition: color 0.2s;
}

.toast-notification .close-btn:hover {
    color: var(--neutral-200);
}

/* ===== RESPONSIVE DESIGN ===== */
@media screen and (max-width: 768px) {
    .kasir-management {
        padding: 16px;
        padding-top: 70px;
    }
    
    .kasir-header {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
    }
    
    .page-title {
        font-size: 24px;
    }
    
    .modal-content {
        margin: 20px auto;
        width: 95%;
    }
    
    .modal-actions {
        flex-direction: column;
    }
    
    .btn-primary, .btn-secondary {
        width: 100%;
        justify-content: center;
    }
}

@media screen and (max-width: 480px) {
    .action-buttons {
        flex-direction: column;
        gap: 6px;
    }
    
    .btn-edit, .btn-delete {
        width: 100%;
        min-width: auto;
    }
    
    .kasir-table {
        min-width: 500px;
    }
    
    .kasir-table th,
    .kasir-table td {
        padding: 12px 16px;
    }
    
    .modal-form {
        padding: 20px;
    }
    
    .modal-header {
        padding: 20px 20px 0 20px;
    }
}
</style>

<div class="kasir-management">
    <!-- Header Section -->
    <div class="kasir-header">
        <div class="header-content">
            <h1 class="page-title">Manajemen Kasir</h1>
            <p class="page-subtitle">Kelola data kasir dan akses sistem</p>
        </div>
        <button class="btn-primary" onclick="openModal()">
            <span class="btn-icon">+</span>
            Tambah Kasir
        </button>
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
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="currentColor" stroke-width="2"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                    Edit
                                </button>
                                <form action="{{ route('kasir.delete', $usr->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kasir ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="2"/>
                                            <path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2"/>
                                        </svg>
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
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
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
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2"/>
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                        </svg>
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
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
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
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2"/>
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                        </svg>
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
function openModal() {
    document.getElementById('modalKasir').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('modalKasir').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function openEditModal(id, username) {
    const modal = document.getElementById('modalEditKasir');
    const form = document.getElementById('editKasirForm');
    
    // Set form action
    form.action = "{{ route('kasir.update', ':id') }}".replace(':id', id);
    
    // Fill form data
    document.getElementById('edit_username').value = username;
    document.getElementById('edit_password').value = "";
    
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('modalEditKasir').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Password Toggle Function
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
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