# Design System & UI Components Plan: BPHTB Online

Dokumen ini berisi spesifikasi *Design Tokens*, panduan komponen UI reusable, dan struktur tata letak halaman berdasarkan referensi desain **Stitch** di folder [`design/stitch_screens/`](file:///d:/laragon/www/bphtb-online/design/stitch_screens).

---

## 1. Design Tokens & Theme Configuration

### Color Palette
- **Primary:** `#1E3A8A` (Deep Navy / Primary Brand)
- **Primary Light / Hover:** `#2563EB` (Royal Blue)
- **Secondary:** `#0D9488` (Teal / Accent)
- **Neutral Background:** `#F8FAFC` (Slate 50)
- **Neutral Surface / Card:** `#FFFFFF` (White)
- **Neutral Text Primary:** `#0F172A` (Slate 900)
- **Neutral Text Muted:** `#64748B` (Slate 500)
- **Border / Divider:** `#E2E8F0` (Slate 200)
- **State & Alert Colors:**
  - Success: `#16A34A` (Green 600)
  - Warning / Pending: `#D97706` (Amber 600)
  - Danger / Error: `#DC2626` (Red 600)
  - Info: `#0284C7` (Sky 600)

### Tipografi
- **Font Family:** `'Inter', 'Roboto', system-ui, sans-serif`
- **Scale:**
  - `h1`: 28px (Bold, Line Height 1.3)
  - `h2`: 22px (Semi-Bold, Line Height 1.3)
  - `h3`: 18px (Semi-Bold, Line Height 1.4)
  - `body`: 14px (Regular, Line Height 1.5)
  - `caption / small`: 12px (Regular, Line Height 1.4)

### Spacing & Breakpoints
- **Grid Spacing:** 4px, 8px, 12px, 16px, 24px, 32px, 48px
- **Breakpoints:**
  - Mobile: `< 640px`
  - Tablet: `640px - 1024px`
  - Desktop: `> 1024px`

---

## 2. Reusable UI Component Library Checklist

### Komponen Atom / Molekul
- [ ] **BaseButton:** Variant (`primary`, `secondary`, `outline`, `danger`), Size (`sm`, `md`, `lg`), Loading state spinner.
- [ ] **BaseInput:** Label, placeholder, validation error state, helper text.
- [ ] **BaseSelect:** Dropdown select dengan search/filter capability.
- [ ] **BaseCheckbox / Radio:** Custom styled checkbox & radio group.
- [ ] **BaseCard:** Container card dengan header, body, dan shadow subtle.
- [ ] **BaseBadge:** Status badge (`terverifikasi`, `pending`, `ditolak`, `draf`).
- [ ] **BaseTable:** Dynamic data table dengan pagination, sorting, dan empty state.
- [ ] **BaseModal:** Dialog overlay untuk konfirmasi & detail transaksi.
- [ ] **ToastNotification:** Pop-up alert untuk notifikasi sukses/gagal.
- [ ] **FileUploadZone:** Drag-and-drop zone untuk dokumen persyaratan (PDF/JPG/PNG).

### Komponen Layout & Navigasi
- [ ] **AppNavbar:** Top navigation bar dengan profil user, notifikasi, dan tombol logout.
- [ ] **AppSidebar:** Left navigation menu dengan indikator halaman aktif.
- [ ] **PageHeader:** Heading halaman + breadcrumb + action buttons.
- [ ] **PageShell:** Container wrapper responsif untuk semua halaman protected.

---

## 3. Static Page Screen Layouts

Berdasarkan berkas desain yang telah diunduh dari proyek **Stitch**:

1. **Halaman Login:** [`01_login.html`](file:///d:/laragon/www/bphtb-online/design/stitch_screens/01_login.html)
2. **Dashboard Monitoring:** [`02_dashboard.html`](file:///d:/laragon/www/bphtb-online/design/stitch_screens/02_dashboard.html)
3. **Input Pendaftaran BPHTB:** [`03_input_pendaftaran.html`](file:///d:/laragon/www/bphtb-online/design/stitch_screens/03_input_pendaftaran.html)
4. **Upload Persyaratan BPHTB:** [`04_upload_persyaratan.html`](file:///d:/laragon/www/bphtb-online/design/stitch_screens/04_upload_persyaratan.html)
5. **Input Data SSPD:** [`05_input_sspd.html`](file:///d:/laragon/www/bphtb-online/design/stitch_screens/05_input_sspd.html)

### Ketentuan State Visual
- **Default State:** Tampilan awal komponen dengan data standar.
- **Hover & Active State:** Perubahan warna subtle pada tombol, baris tabel, dan menu sidebar.
- **Disabled State:** Opacity 50%, pointer-events disabled pada input/tombol yang belum memenuhi syarat.
- **Loading State:** Skeleton loader pada statistik dashboard dan tabel data.
- **Empty State:** Placeholder ilustrasi ketika belum ada transaksi atau berkas diunggah.
- **Error State:** Border merah pada input + pesan validasi merah di bawah bidang yang bermasalah.
