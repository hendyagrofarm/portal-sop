<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  stats: Object,
  latestDocuments: Array,
  categoryBreakdown: Array,
  revokedDocuments: Array,
})

const isAdmin = computed(() => props.stats?.totalUsers !== null)

const statGridClass = computed(() =>
  isAdmin.value
    ? 'grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4'
    : 'grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3'
)
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 shadow-sm">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
          <div class="text-white">
            <p class="text-sm font-medium text-white/80">
              PT Agrofarm Nusa Raya
            </p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight">
              Dashboard Portal SOP
            </h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-white/85">
              Sistem dokumentasi internal untuk mengelola dokumen aktif, histori SOP dicabut,
              dan memantau distribusi dokumen per departemen.
            </p>
          </div>

          <div class="flex flex-wrap gap-2">
            <Link
              :href="route('documents.index')"
              class="rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-emerald-700 shadow-sm hover:bg-emerald-50"
            >
              📄 Lihat Dokumen
            </Link>

            <Link
              href="/tutorial"
              class="rounded-xl bg-white/10 px-4 py-2.5 text-sm font-semibold text-white ring-1 ring-white/20 hover:bg-white/15"
            >
              📘 Tutorial
            </Link>
          </div>
        </div>
      </div>
    </template>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 space-y-8">
      <!-- KPI CARDS -->
      <div :class="statGridClass">
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-sm font-medium text-gray-500">Total Dokumen</p>
              <p class="mt-3 text-4xl font-bold text-gray-900">
                {{ stats.totalDocuments }}
              </p>
              <p class="mt-2 text-sm text-gray-500">Dokumen aktif</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-xl text-emerald-600">
              📄
            </div>
          </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-sm font-medium text-gray-500">Total Departemen</p>
              <p class="mt-3 text-4xl font-bold text-gray-900">
                {{ stats.totalCategories }}
              </p>
              <p class="mt-2 text-sm text-gray-500">Departemen unik</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-xl text-blue-600">
              🏢
            </div>
          </div>
        </div>

        <div
          v-if="isAdmin"
          class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
        >
          <div class="flex items-start justify-between">
            <div>
              <p class="text-sm font-medium text-gray-500">Total User</p>
              <p class="mt-3 text-4xl font-bold text-gray-900">
                {{ stats.totalUsers }}
              </p>
              <p class="mt-2 text-sm text-gray-500">Khusus admin</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-100 text-xl text-purple-600">
              👤
            </div>
          </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-sm font-medium text-gray-500">SOP Dicabut</p>
              <p class="mt-3 text-4xl font-bold text-gray-900">
                {{ stats.totalRevoked }}
              </p>
              <p class="mt-2 text-sm text-gray-500">Histori dokumen tidak aktif</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-100 text-xl text-red-600">
              ⚠️
            </div>
          </div>
        </div>
      </div>

      <!-- QUICK ACTION -->
      <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
            <p class="mt-1 text-sm text-gray-500">
              Akses cepat untuk pengelolaan dokumen SOP
            </p>
          </div>

          <div class="flex flex-wrap gap-3">
            <Link
              :href="route('documents.index')"
              class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50"
            >
              <span>📄</span>
              <span>Semua Dokumen</span>
            </Link>

            <Link
              :href="route('documents.history')"
              class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50"
            >
              <span>🗂</span>
              <span>Histori SOP</span>
            </Link>

            <Link
              href="/tutorial"
              class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50"
            >
              <span>📘</span>
              <span>Tutorial</span>
            </Link>

            <Link
              v-if="isAdmin"
              :href="route('documents.create')"
              class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700"
            >
              <span>＋</span>
              <span>Tambah SOP</span>
            </Link>
          </div>
        </div>
      </div>

      <!-- DOKUMEN TERBARU -->
      <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
          <div>
            <h3 class="text-lg font-semibold text-gray-900">Dokumen Terbaru</h3>
            <p class="mt-1 text-sm text-gray-500">
              5 dokumen aktif yang terakhir diperbarui
            </p>
          </div>

          <Link
            v-if="latestDocuments.length"
            :href="route('documents.index')"
            class="text-sm font-medium text-emerald-700 hover:underline"
          >
            Buka semua
          </Link>
        </div>

        <div class="px-6 py-5">
          <div
            v-if="!latestDocuments.length"
            class="rounded-2xl bg-gray-50 px-4 py-10 text-center text-sm text-gray-500"
          >
            📭 Belum ada dokumen aktif.
          </div>

          <div v-else class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
              <thead class="border-b bg-gray-50 text-gray-600">
                <tr>
                  <th class="px-4 py-3 font-semibold">Nomor</th>
                  <th class="px-4 py-3 font-semibold">Judul</th>
                  <th class="px-4 py-3 font-semibold">Departemen</th>
                  <th class="px-4 py-3 font-semibold">Update</th>
                  <th class="px-4 py-3 font-semibold">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="doc in latestDocuments"
                  :key="doc.id"
                  class="border-b transition hover:bg-gray-50"
                >
                  <td class="px-4 py-3 font-medium text-gray-900">
                    {{ doc.nomor_dokumen }}
                  </td>
                  <td class="px-4 py-3 text-gray-800">
                    {{ doc.judul }}
                  </td>
                  <td class="px-4 py-3">
                    <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                      {{ doc.kategori || '-' }}
                    </span>
                  </td>
                  <td class="px-4 py-3 text-gray-600">
                    {{ new Date(doc.updated_at).toLocaleString() }}
                  </td>
                  <td class="px-4 py-3">
                    <Link
                      :href="route('documents.open', doc.id)"
                      target="_blank"
                      class="rounded-lg bg-emerald-50 px-3 py-1.5 text-sm font-semibold text-emerald-700 hover:bg-emerald-100"
                    >
                      Buka
                    </Link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- HISTORI SOP DICABUT -->
      <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
          <div>
            <h3 class="text-lg font-semibold text-gray-900">Histori SOP Dicabut</h3>
            <p class="mt-1 text-sm text-gray-500">
              Dokumen yang sudah tidak digunakan atau sudah dicabut
            </p>
          </div>

          <Link
            v-if="revokedDocuments.length"
            href="/documents/history"
            class="text-sm font-medium text-emerald-700 hover:underline"
          >
            Lihat semua
          </Link>
        </div>

        <div class="px-6 py-5">
          <div
            v-if="!revokedDocuments.length"
            class="rounded-2xl bg-gray-50 px-4 py-10 text-center text-sm text-gray-500"
          >
            🗃 Belum ada histori SOP dicabut.
          </div>

          <div v-else class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
              <thead class="border-b bg-gray-50 text-gray-600">
                <tr>
                  <th class="px-4 py-3 font-semibold">Nomor</th>
                  <th class="px-4 py-3 font-semibold">Judul</th>
                  <th class="px-4 py-3 font-semibold">Departemen</th>
                  <th class="px-4 py-3 font-semibold">Tanggal Dicabut</th>
                  <th class="px-4 py-3 font-semibold">Alasan</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="doc in revokedDocuments"
                  :key="doc.id"
                  class="border-b transition hover:bg-gray-50"
                >
                  <td class="px-4 py-3 font-medium text-gray-900">
                    {{ doc.nomor_dokumen }}
                  </td>
                  <td class="px-4 py-3 text-gray-800">
                    {{ doc.judul }}
                  </td>
                  <td class="px-4 py-3">
                    <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                      {{ doc.kategori || '-' }}
                    </span>
                  </td>
                  <td class="px-4 py-3 text-gray-600">
                    {{ doc.revoked_at ? new Date(doc.revoked_at).toLocaleString() : '-' }}
                  </td>
                  <td class="px-4 py-3 text-gray-700">
                    {{ doc.revoked_reason || '-' }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- DEPARTEMEN TERBANYAK -->
      <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="border-b border-gray-100 px-6 py-4">
          <h3 class="text-lg font-semibold text-gray-900">Departemen Terbanyak</h3>
          <p class="mt-1 text-sm text-gray-500">
            Top 8 departemen berdasarkan jumlah dokumen aktif
          </p>
        </div>

        <div class="px-6 py-5">
          <div
            v-if="!categoryBreakdown.length"
            class="rounded-2xl bg-gray-50 px-4 py-10 text-center text-sm text-gray-500"
          >
            📊 Belum ada data departemen.
          </div>

          <div v-else class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div
              v-for="row in categoryBreakdown"
              :key="row.kategori"
              class="rounded-2xl border border-gray-100 bg-gray-50 p-5 transition hover:-translate-y-0.5 hover:shadow-sm"
            >
              <div class="text-sm font-semibold text-gray-800">
                {{ row.kategori }}
              </div>
              <div class="mt-3 text-3xl font-bold text-gray-900">
                {{ row.total }}
              </div>
              <div class="mt-1 text-sm text-gray-500">dokumen</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>