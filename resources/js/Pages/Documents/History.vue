<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
  documents: Object,
  filters: Object,
  kategoriList: Array,
})

const page = usePage()
const isAdmin = computed(() => page.props.auth?.user?.role === 'admin')

const q = ref(props.filters?.q || '')
const kategori = ref(props.filters?.kategori || '')

const submitFilter = () => {
  router.get(route('documents.history'), {
    q: q.value,
    kategori: kategori.value,
  }, {
    preserveState: true,
    replace: true,
  })
}

const resetFilter = () => {
  q.value = ''
  kategori.value = ''
  router.get(route('documents.history'), {}, {
    preserveState: true,
    replace: true,
  })
}

/*
|--------------------------------------------------------------------------
| Modal pulihkan SOP
|--------------------------------------------------------------------------
*/
const showRestoreModal = ref(false)
const selectedId = ref(null)

const openRestoreModal = (id) => {
  selectedId.value = id
  showRestoreModal.value = true
}

const closeRestoreModal = () => {
  showRestoreModal.value = false
  selectedId.value = null
}

const submitRestore = () => {
  router.patch(route('documents.restore', selectedId.value), {}, {
    preserveScroll: true,
    onSuccess: () => closeRestoreModal(),
  })
}

const formatDateTime = (value) => {
  if (!value) return '-'
  return new Date(value).toLocaleString('id-ID', {
    dateStyle: 'medium',
    timeStyle: 'short',
  })
}
</script>

<template>
  <Head title="Histori SOP Dicabut" />

  <AuthenticatedLayout>
    <template #header>
      <div class="rounded-3xl bg-gradient-to-r from-rose-600 via-red-600 to-orange-500 p-6 shadow-sm">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
          <div class="text-white">
            <p class="text-sm font-medium text-white/80">
              PT Agrofarm Nusa Raya
            </p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight">
              Histori SOP Dicabut
            </h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-white/85">
              Daftar dokumen yang sudah dicabut, tidak berlaku lagi, atau telah digantikan
              oleh versi SOP yang lebih baru.
            </p>
          </div>

          <div class="flex flex-wrap gap-2">
            <Link
              :href="route('documents.index')"
              class="rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-rose-700 shadow-sm hover:bg-rose-50"
            >
              📄 Dokumen Aktif
            </Link>

            <Link
              :href="route('dashboard')"
              class="rounded-xl bg-white/10 px-4 py-2.5 text-sm font-semibold text-white ring-1 ring-white/20 hover:bg-white/15"
            >
              📊 Dashboard
            </Link>
          </div>
        </div>
      </div>
    </template>

    <div class="min-h-screen bg-slate-100">
      <div class="mx-auto max-w-7xl space-y-6 px-6 py-6">

        <!-- FILTER -->
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
          <div class="mb-5">
            <h3 class="text-xl font-bold text-slate-900">Filter Histori SOP</h3>
            <p class="mt-1 text-sm text-slate-500">
              Cari berdasarkan nomor dokumen, judul, atau departemen.
            </p>
          </div>

          <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">
            <div class="xl:col-span-5">
              <input
                v-model="q"
                type="text"
                placeholder="Cari nomor atau judul dokumen..."
                class="w-full rounded-2xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500"
                @keyup.enter="submitFilter"
              />
            </div>

            <div class="xl:col-span-4">
              <select
                v-model="kategori"
                class="w-full rounded-2xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-rose-500 focus:ring-rose-500"
              >
                <option value="">Semua Departemen</option>
                <option
                  v-for="item in kategoriList"
                  :key="item"
                  :value="item"
                >
                  {{ item }}
                </option>
              </select>
            </div>

            <div class="flex flex-wrap gap-3 xl:col-span-3 xl:justify-end">
              <button
                type="button"
                @click="submitFilter"
                class="rounded-2xl bg-rose-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700"
              >
                Cari
              </button>

              <button
                type="button"
                @click="resetFilter"
                class="rounded-2xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
              >
                Reset
              </button>
            </div>
          </div>
        </section>

        <!-- TABLE -->
        <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
          <div class="border-b border-slate-200 px-6 py-5">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <h3 class="text-xl font-bold text-slate-900">Daftar Histori SOP Dicabut</h3>
                <p class="mt-1 text-sm text-slate-500">
                  <template v-if="documents.total > 0">
                    Menampilkan {{ documents.from }}–{{ documents.to }} dari {{ documents.total }} dokumen dicabut
                  </template>
                  <template v-else>
                    Tidak ada histori SOP dicabut
                  </template>
                </p>
              </div>

              <div class="rounded-2xl bg-rose-50 px-4 py-2 text-sm font-medium text-rose-700">
                Status: Revoked
              </div>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
              <thead class="bg-slate-50 text-slate-600">
                <tr>
                  <th class="px-6 py-4 font-semibold">Nomor Dokumen</th>
                  <th class="px-6 py-4 font-semibold">Judul</th>
                  <th class="px-6 py-4 font-semibold">Departemen</th>
                  <th class="px-6 py-4 font-semibold">Tanggal Dicabut</th>
                  <th class="px-6 py-4 font-semibold">Alasan</th>
                  <th class="px-6 py-4 font-semibold">Aksi</th>
                </tr>
              </thead>

              <tbody class="divide-y divide-slate-100 bg-white">
                <tr v-if="!documents.data.length">
                  <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                    <div class="space-y-2">
                      <div class="text-4xl">🗂️</div>
                      <div class="font-semibold text-slate-700">Belum ada histori SOP dicabut</div>
                      <div class="text-sm">Dokumen yang dicabut akan muncul di halaman ini.</div>
                    </div>
                  </td>
                </tr>

                <tr
                  v-for="doc in documents.data"
                  :key="doc.id"
                  class="transition hover:bg-slate-50"
                >
                  <td class="px-6 py-4">
                    <div class="font-semibold text-slate-900">
                      {{ doc.nomor_dokumen }}
                    </div>
                  </td>

                  <td class="px-6 py-4 text-slate-800">
                    {{ doc.judul }}
                  </td>

                  <td class="px-6 py-4">
                    <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-rose-700">
                      {{ doc.kategori || '-' }}
                    </span>
                  </td>

                  <td class="px-6 py-4 text-slate-600">
                    {{ formatDateTime(doc.revoked_at) }}
                  </td>

                  <td class="px-6 py-4 text-slate-700">
                    <div class="max-w-md whitespace-pre-line">
                      {{ doc.revoked_reason || '-' }}
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    <div class="flex flex-wrap items-center gap-2">
                      <button
                        v-if="isAdmin"
                        type="button"
                        @click="openRestoreModal(doc.id)"
                        class="rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                      >
                        Pulihkan
                      </button>

                      <span
                        v-if="!isAdmin"
                        class="text-xs italic text-slate-400"
                      >
                        Read only
                      </span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- PAGINATION -->
          <div
            v-if="documents.links?.length"
            class="border-t border-slate-200 px-6 py-4"
          >
            <div class="flex flex-wrap gap-2">
              <button
                v-for="(link, index) in documents.links"
                :key="index"
                v-html="link.label"
                :disabled="!link.url"
                @click="link.url && router.visit(link.url)"
                class="rounded-xl px-4 py-2 text-sm font-medium transition"
                :class="[
                  link.active
                    ? 'bg-rose-600 text-white'
                    : 'bg-slate-100 text-slate-700 hover:bg-slate-200',
                  !link.url ? 'cursor-not-allowed opacity-50' : ''
                ]"
                type="button"
              />
            </div>
          </div>
        </section>
      </div>
    </div>

    <!-- MODAL PULIHKAN SOP -->
    <div
      v-if="showRestoreModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
    >
      <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">
        <h3 class="text-xl font-bold text-slate-900">
          Pulihkan SOP
        </h3>

        <p class="mt-2 text-sm text-slate-500">
          Dokumen ini akan dikembalikan ke daftar dokumen aktif.
        </p>

        <div class="mt-6 flex justify-end gap-3">
          <button
            type="button"
            @click="closeRestoreModal"
            class="rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200"
          >
            Batal
          </button>

          <button
            type="button"
            @click="submitRestore"
            class="rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
          >
            Pulihkan
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>