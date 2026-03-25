<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const isAdmin = computed(() => page.props.auth?.user?.role === 'admin')
</script>

<template>
  <Head title="Tutorial Portal SOP" />

  <AuthenticatedLayout>
    <template #header>
      <div class="rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 shadow-sm">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
          <div class="text-white">
            <p class="text-sm font-medium text-white/80">
              PT Agrofarm Nusa Raya
            </p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight">
              Tutorial Portal SOP
            </h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-white/85">
              Panduan penggunaan sistem dokumentasi internal untuk mengelola dokumen aktif,
              histori SOP dicabut, dan distribusi dokumen antar departemen.
            </p>
          </div>

          <div class="flex flex-wrap gap-2">
            <Link
              :href="route('dashboard')"
              class="rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-emerald-700 shadow-sm hover:bg-emerald-50"
            >
              📊 Dashboard
            </Link>

            <Link
              :href="route('documents.index')"
              class="rounded-xl bg-white/10 px-4 py-2.5 text-sm font-semibold text-white ring-1 ring-white/20 hover:bg-white/15"
            >
              📄 Buka Dokumen
            </Link>
          </div>
        </div>
      </div>
    </template>

    <div class="min-h-screen bg-slate-100">
      <div class="mx-auto max-w-7xl space-y-6 px-6 py-6">

        <!-- INTRO -->
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
          <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-3xl">
              <h3 class="text-xl font-bold text-slate-900">
                Tentang Portal SOP
              </h3>
              <p class="mt-3 text-sm leading-7 text-slate-600">
                Portal SOP adalah sistem internal untuk mengelola dan mengakses dokumen
                Standar Operasional Prosedur, Instruksi Kerja, Formulir, dan dokumen terkait.
                Sehingga pengguna dapat membuka dokumen langsung dari portal.
              </p>
              <p class="mt-3 text-sm leading-7 text-slate-600">
                Hak akses dibedakan berdasarkan peran pengguna:
                <span class="font-semibold text-slate-800">Admin</span> dan
                <span class="font-semibold text-slate-800">User</span>.
                Admin dapat mengelola dokumen, sedangkan user fokus pada pencarian dan pembukaan dokumen.
              </p>
            </div>

            <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 ring-1 ring-emerald-100">
              <div class="font-semibold">Tips</div>
              <div class="mt-1">
                Gunakan fitur pencarian dan filter departemen untuk menemukan dokumen lebih cepat.
              </div>
            </div>
          </div>
        </section>

        <!-- QUICK OVERVIEW -->
        <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
          <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <div class="text-sm font-medium text-slate-500">Akses Umum</div>
            <div class="mt-3 text-lg font-bold text-slate-900">Buka Dokumen</div>
            <p class="mt-2 text-sm text-slate-500">
              User dan admin dapat mencari serta membuka dokumen aktif.
            </p>
          </div>

          <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <div class="text-sm font-medium text-slate-500">Pengelolaan</div>
            <div class="mt-3 text-lg font-bold text-slate-900">Tambah / Edit</div>
            <p class="mt-2 text-sm text-slate-500">
              Hanya admin yang dapat menambah dan mengubah data dokumen.
            </p>
          </div>

          <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <div class="text-sm font-medium text-slate-500">Status Dokumen</div>
            <div class="mt-3 text-lg font-bold text-slate-900">Cabut SOP</div>
            <p class="mt-2 text-sm text-slate-500">
              SOP yang tidak digunakan dapat dipindahkan ke histori.
            </p>
          </div>

        </section>

        <!-- JENIS DOKUMEN -->
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
          <h3 class="text-xl font-bold text-slate-900">
            Jenis Dokumen SOP
          </h3>

          <p class="mt-2 text-sm text-slate-500">
            Berikut adalah penjelasan singkatan yang digunakan dalam penomoran dokumen.
          </p>

          <div class="mt-6 overflow-x-auto">
            <table class="min-w-full text-left text-sm">
              <thead class="bg-slate-50 text-slate-600">
                <tr>
                  <th class="px-4 py-3 font-semibold">Kode</th>
                  <th class="px-4 py-3 font-semibold">Nama Dokumen</th>
                  <th class="px-4 py-3 font-semibold">Deskripsi</th>
                </tr>
              </thead>

              <tbody class="divide-y divide-slate-100">
                <tr>
                  <td class="px-4 py-3 font-bold text-blue-600">SOP</td>
                  <td class="px-4 py-3 text-slate-800">Standard Operating Procedure</td>
                  <td class="px-4 py-3 text-slate-600">
                    Dokumen utama yang berisi prosedur kerja standar dalam suatu proses.
                  </td>
                </tr>

                <tr>
                  <td class="px-4 py-3 font-bold text-emerald-600">IK</td>
                  <td class="px-4 py-3 text-slate-800">Instruksi Kerja</td>
                  <td class="px-4 py-3 text-slate-600">
                    Panduan teknis yang lebih detail untuk menjalankan suatu pekerjaan tertentu.
                  </td>
                </tr>

                <tr>
                  <td class="px-4 py-3 font-bold text-amber-600">FM</td>
                  <td class="px-4 py-3 text-slate-800">Formulir</td>
                  <td class="px-4 py-3 text-slate-600">
                    Dokumen pendukung berupa form isian yang digunakan dalam proses kerja.
                  </td>
                </tr>

                <tr>
                  <td class="px-4 py-3 font-bold text-violet-600">PM</td>
                  <td class="px-4 py-3 text-slate-800">Pedoman Mutu</td>
                  <td class="px-4 py-3 text-slate-600">
                    Panduan yang berisi persyaratan untuk menerapkan, memelihara, dan meningkatkan sistem.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <!-- FORMAT NOMOR DOKUMEN -->
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
          <h3 class="text-xl font-bold text-slate-900">
            Format Nomor Dokumen
          </h3>

          <p class="mt-2 text-sm text-slate-500">
            Contoh penomoran dokumen:
          </p>

          <div class="mt-4 rounded-2xl bg-slate-50 p-4 font-mono text-sm text-slate-800 ring-1 ring-slate-200">
            ANR-IK-FNC-08-02
          </div>

          <div class="mt-5 grid gap-3 md:grid-cols-2">
            <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-600 ring-1 ring-slate-200">
              <span class="font-semibold text-slate-800">ANR</span> → Identitas / singkatan perusahaan
            </div>
            <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-600 ring-1 ring-slate-200">
              <span class="font-semibold text-slate-800">IK</span> → Jenis dokumen (Instruksi Kerja)
            </div>
            <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-600 ring-1 ring-slate-200">
              <span class="font-semibold text-slate-800">FNC</span> → Kode departemen (Finance)
            </div>
            <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-600 ring-1 ring-slate-200">
              <span class="font-semibold text-slate-800">08</span> → Nomor urut dokumen
            </div>
            <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-600 ring-1 ring-slate-200 md:col-span-2">
              <span class="font-semibold text-slate-800">02</span> → Nomor revisi / versi dokumen
            </div>
          </div>
        </section>

        <!-- PANDUAN USER -->
        <section class="rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
          <div class="border-b border-slate-200 px-6 py-4">
            <h3 class="text-xl font-bold text-slate-900">
              Panduan User
            </h3>
            <p class="mt-1 text-sm text-slate-500">
              Langkah dasar untuk mencari dan membuka dokumen
            </p>
          </div>

          <div class="space-y-4 px-6 py-6">
            <div class="rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
              <div class="text-sm font-semibold text-emerald-700">Langkah 1</div>
              <div class="mt-2 text-base font-bold text-slate-900">
                Buka menu Dokumen
              </div>
              <p class="mt-2 text-sm leading-7 text-slate-600">
                Masuk ke halaman <span class="font-semibold text-slate-800">Dokumen Portal SOP</span>
                dari dashboard atau menu navigasi.
              </p>
            </div>

            <div class="rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
              <div class="text-sm font-semibold text-emerald-700">Langkah 2</div>
              <div class="mt-2 text-base font-bold text-slate-900">
                Cari dokumen berdasarkan nomor atau judul
              </div>
              <p class="mt-2 text-sm leading-7 text-slate-600">
                Gunakan kolom pencarian untuk mengetik nomor dokumen, judul SOP,
                atau kata kunci tertentu.
              </p>
            </div>

            <div class="rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
              <div class="text-sm font-semibold text-emerald-700">Langkah 3</div>
              <div class="mt-2 text-base font-bold text-slate-900">
                Gunakan filter departemen
              </div>
              <p class="mt-2 text-sm leading-7 text-slate-600">
                Pilih departemen untuk mempersempit hasil pencarian sesuai kebutuhan.
              </p>
            </div>

            <div class="rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
              <div class="text-sm font-semibold text-emerald-700">Langkah 4</div>
              <div class="mt-2 text-base font-bold text-slate-900">
                Klik tombol “Buka”
              </div>
              <p class="mt-2 text-sm leading-7 text-slate-600">
                Sistem akan mengarahkan langsung ke link dokumen yang tersimpan
                pada Drive atau URL terkait.
              </p>
            </div>
          </div>
        </section>

        <!-- PANDUAN ADMIN -->
        <section
          v-if="isAdmin"
          class="rounded-3xl bg-white shadow-sm ring-1 ring-slate-200"
        >
          <div class="border-b border-slate-200 px-6 py-4">
            <h3 class="text-xl font-bold text-slate-900">
              Panduan Admin
            </h3>
            <p class="mt-1 text-sm text-slate-500">
              Langkah pengelolaan dokumen oleh administrator
            </p>
          </div>

          <div class="space-y-4 px-6 py-6">
            <div class="rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
              <div class="text-sm font-semibold text-blue-700">Langkah 1</div>
              <div class="mt-2 text-base font-bold text-slate-900">
                Tambah dokumen baru
              </div>
              <p class="mt-2 text-sm leading-7 text-slate-600">
                Klik tombol <span class="font-semibold text-slate-800">+ Tambah Dokumen</span>,
                lalu isi nomor dokumen, judul, departemen, deskripsi, dan link dokumen.
              </p>
            </div>

            <div class="rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
              <div class="text-sm font-semibold text-blue-700">Langkah 2</div>
              <div class="mt-2 text-base font-bold text-slate-900">
                Edit dokumen
              </div>
              <p class="mt-2 text-sm leading-7 text-slate-600">
                Jika ada perubahan judul, departemen, deskripsi, atau link,
                klik tombol <span class="font-semibold text-slate-800">Edit</span>.
              </p>
            </div>

            <div class="rounded-2xl bg-slate-50 p-5 ring-1 ring-slate-200">
              <div class="text-sm font-semibold text-blue-700">Langkah 3</div>
              <div class="mt-2 text-base font-bold text-slate-900">
                Hapus dokumen
              </div>
              <p class="mt-2 text-sm leading-7 text-slate-600">
                Gunakan tombol <span class="font-semibold text-slate-800">Hapus</span>
                bila dokumen memang harus dihapus permanen dari sistem.
              </p>
            </div>
          </div>
        </section>

        <!-- CABUT SOP -->
        <section class="rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
          <div class="border-b border-slate-200 px-6 py-4">
            <h3 class="text-xl font-bold text-slate-900">
              Cara Mencabut SOP
            </h3>
            <p class="mt-1 text-sm text-slate-500">
              Digunakan ketika dokumen sudah tidak berlaku atau diganti versi baru
            </p>
          </div>

          <div class="space-y-4 px-6 py-6">
            <div class="rounded-2xl bg-amber-50 p-5 ring-1 ring-amber-100">
              <div class="text-sm font-semibold text-amber-700">Langkah 1</div>
              <div class="mt-2 text-base font-bold text-slate-900">
                Buka halaman Dokumen
              </div>
              <p class="mt-2 text-sm leading-7 text-slate-600">
                Cari dokumen aktif yang ingin dicabut dari penggunaan.
              </p>
            </div>

            <div class="rounded-2xl bg-amber-50 p-5 ring-1 ring-amber-100">
              <div class="text-sm font-semibold text-amber-700">Langkah 2</div>
              <div class="mt-2 text-base font-bold text-slate-900">
                Klik tombol “Cabut”
              </div>
              <p class="mt-2 text-sm leading-7 text-slate-600">
                Tombol ini hanya tersedia untuk admin.
              </p>
            </div>

            <div class="rounded-2xl bg-amber-50 p-5 ring-1 ring-amber-100">
              <div class="text-sm font-semibold text-amber-700">Langkah 3</div>
              <div class="mt-2 text-base font-bold text-slate-900">
                Isi alasan pencabutan
              </div>
              <p class="mt-2 text-sm leading-7 text-slate-600">
                Tuliskan alasan yang jelas, misalnya: diganti dokumen baru,
                tidak berlaku, atau revisi sistem.
              </p>
            </div>

            <div class="rounded-2xl bg-amber-50 p-5 ring-1 ring-amber-100">
              <div class="text-sm font-semibold text-amber-700">Langkah 4</div>
              <div class="mt-2 text-base font-bold text-slate-900">
                Dokumen masuk ke histori SOP dicabut
              </div>
              <p class="mt-2 text-sm leading-7 text-slate-600">
                Dokumen tidak lagi tampil di daftar aktif, tetapi tetap tersimpan
                sebagai histori untuk kebutuhan audit dan pelacakan.
              </p>
            </div>
          </div>
        </section>

        <!-- CATATAN -->
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
          <h3 class="text-xl font-bold text-slate-900">
            Catatan Penting
          </h3>

          <div class="mt-4 grid gap-4 md:grid-cols-2">
            <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-200">
              <div class="text-sm font-semibold text-slate-800">
                1. Dokumen aktif
              </div>
              <p class="mt-2 text-sm text-slate-600">
                Hanya dokumen dengan status aktif yang tampil di halaman Dokumen Portal SOP.
              </p>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-200">
              <div class="text-sm font-semibold text-slate-800">
                2. Histori tidak dihapus
              </div>
              <p class="mt-2 text-sm text-slate-600">
                SOP yang dicabut tetap tersimpan di histori untuk kebutuhan audit dan pelacakan.
              </p>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-200">
              <div class="text-sm font-semibold text-slate-800">
                3. User bersifat read only
              </div>
              <p class="mt-2 text-sm text-slate-600">
                User biasa hanya dapat melihat dan membuka dokumen, tanpa mengubah data.
              </p>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-200">
              <div class="text-sm font-semibold text-slate-800">
                4. Admin bertanggung jawab
              </div>
              <p class="mt-2 text-sm text-slate-600">
                Admin bertanggung jawab atas pengelolaan, pencabutan, dan pemulihan dokumen.
              </p>
            </div>
          </div>
        </section>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
