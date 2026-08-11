import { Head } from '@inertiajs/react';
import EconomicPotentialCard from '@/Components/EconomicPotentialCard';
import Pagination from '@/Components/Pagination';
import SectorFilterPills from '@/Components/SectorFilterPills';
import UmkmHeroSlider from '@/Components/UmkmHeroSlider';
import PublicLayout from '@/Layouts/PublicLayout';
import type { UmkmIndexProps } from '@/types';

export default function UmkmIndex({ slides, sectors, activeSector, potentials }: UmkmIndexProps) {
  return (
    <PublicLayout>
      <Head title="UMKM & Potensi Ekonomi" />

      <div className="bg-background-alt pb-section-mobile pt-10 md:pb-section-desktop md:pt-14">
        <div className="mx-auto max-w-container px-4 md:px-6 ">
          <div className="mx-auto max-w-2xl text-center py-8">
            <h1 className="font-display text-3xl font-bold text-ink md:text-5xl">UMKM &amp; Potensi Ekonomi</h1>
            <p className="mt-4 text-body">
              Produk unggulan dan usaha warga yang menjadi urat nadi perekonomian Desa Puraseda.
            </p>
          </div>

          <UmkmHeroSlider slides={slides} />

          <div className="mt-12 flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <h2 className="font-display text-2xl font-semibold text-ink">Semua UMKM</h2>
            <SectorFilterPills sectors={sectors} active={activeSector} />
          </div>

          {potentials.data.length > 0 ? (
            <div className="mt-8 grid gap-6 md:grid-cols-3">
              {potentials.data.map((potential) => (
                <EconomicPotentialCard key={potential.slug} potential={potential} />
              ))}
            </div>
          ) : (
            <p className="mt-8 text-center text-muted">Belum ada UMKM untuk sektor ini.</p>
          )}

          <Pagination links={potentials.links} />
        </div>
      </div>
    </PublicLayout>
  );
}
