import { Head } from '@inertiajs/react';
import { MapPin } from 'lucide-react';
import RelatedCarousel from '@/Components/RelatedCarousel';
import PublicLayout from '@/Layouts/PublicLayout';
import type { DestinationShowProps } from '@/types';

export default function DestinationShow({ destination, related }: DestinationShowProps) {
  return (
    <PublicLayout>
      <Head title={destination.name} />

      <article className="bg-background-alt py-section-mobile md:py-section-desktop">
        <div className="mx-auto max-w-3xl px-4 text-center md:px-6">
          <span className="font-display text-sm font-semibold uppercase tracking-wider text-secondary">
            {destination.categoryLabel}
          </span>
          <h1 className="mt-2 font-display text-3xl font-bold text-ink md:text-4xl">{destination.name}</h1>
          <p className="mt-2 flex items-center justify-center gap-1.5 text-sm text-muted">
            <MapPin className="h-4 w-4" /> {destination.hamletName}
          </p>

          <div className="relative mx-auto mt-8 aspect-[16/9] w-full overflow-hidden rounded-card bg-secondary-container">
            {destination.coverUrl ? (
              <img src={destination.coverUrl} alt={destination.name} className="h-full w-full object-cover" loading="eager" />
            ) : (
              <div className="flex h-full w-full items-center justify-center font-display text-sm text-secondary">
                Desa Puraseda
              </div>
            )}
          </div>

          <div className="article-body mt-8 text-left" dangerouslySetInnerHTML={{ __html: destination.description }} />

          <a
            href={destination.mapsUrl}
            target="_blank"
            rel="noreferrer"
            className="mt-8 inline-flex items-center gap-2 rounded-button bg-primary px-6 py-3 font-display text-sm font-semibold text-on-primary transition-colors hover:bg-primary-hover"
          >
            <MapPin className="h-4 w-4" /> Lihat Lokasi
          </a>
        </div>
      </article>

      <RelatedCarousel
        title="Destinasi Lainnya"
        items={related.map((item) => ({
          key: item.slug,
          href: `/potensi-wisata/${item.slug}`,
          imageUrl: item.coverUrl,
          title: item.name,
          subtitle: item.shortDescription,
          badge: item.categoryLabel,
        }))}
      />
    </PublicLayout>
  );
}
