import { Head } from '@inertiajs/react';
import DestinationCard from '@/Components/DestinationCard';
import DestinationHeroSlider from '@/Components/DestinationHeroSlider';
import Pagination from '@/Components/Pagination';
import PublicLayout from '@/Layouts/PublicLayout';
import type { DestinationsIndexProps } from '@/types';

export default function DestinationsIndex({ slides, destinations }: DestinationsIndexProps) {
  return (
    <PublicLayout>
      <Head title="Potensi Wisata" />

      <div className="bg-background-alt pb-section-mobile pt-10 md:pb-section-desktop md:pt-14">
        <div className="mx-auto max-w-container px-4 md:px-6 ">
          <div className="mx-auto max-w-2xl text-center py-8">
            <h1 className="font-display text-3xl font-bold text-ink md:text-5xl">Potensi Wisata</h1>
            <p className="mt-4 text-body">
              Keindahan alam dan destinasi unggulan yang bisa dijelajahi di Desa Puraseda.
            </p>
          </div>

          <DestinationHeroSlider slides={slides} />

          <h2 className="mt-12 font-display text-2xl font-semibold text-ink">Semua Destinasi</h2>

          {destinations.data.length > 0 ? (
            <div className="mt-8 grid gap-6 md:grid-cols-3">
              {destinations.data.map((destination) => (
                <DestinationCard key={destination.slug} destination={destination} />
              ))}
            </div>
          ) : (
            <p className="mt-8 text-center text-muted">Belum ada destinasi wisata.</p>
          )}

          <Pagination links={destinations.links} />
        </div>
      </div>
    </PublicLayout>
  );
}
