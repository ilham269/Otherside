@if(session('success'))
<div class="alert-toast success" id="alertToast">
    <i class="fa-solid fa-circle-check"></i>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert-toast error" id="alertToast">
    <i class="fa-solid fa-circle-xmark"></i>
    {{ session('error') }}
</div>
@endif

<style>
.alert-toast {
    position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 9999;
    display: flex; align-items: center; gap: .6rem;
    padding: .75rem 1.25rem; border-radius: 12px;
    font-size: .85rem; font-weight: 600;
    box-shadow: 0 8px 24px rgba(0,0,0,.12);
    animation: slideIn .3s ease;
}
.alert-toast.success { background: #d1fae5; color: #065f46; }
.alert-toast.error   { background: #fee2e2; color: #991b1b; }
@keyframes slideIn { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>
<script>
setTimeout(() => document.getElementById('alertToast')?.remove(), 3500);
</script>
