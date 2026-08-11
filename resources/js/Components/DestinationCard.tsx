import { Link } from '@inertiajs/react';
import { MapPin } from 'lucide-react';
import type { DestinationCard as DestinationCardType } from '@/types';

export default function DestinationCard({ destination }: { destination: DestinationCardType }) {
  return (
    <Link
      href={`/potensi-wisata/${destination.slug}`}
      className="group flex flex-col overflow-hidden rounded-card border border-border bg-surface transition-colors hover:border-secondary"
    >
      <div className="relative aspect-[16/9] w-full overflow-hidden bg-secondary-container">
        {destination.coverUrl ? (
          <img src={destination.coverUrl} alt={destination.name} className="h-full w-full object-cover" loading="lazy" />
        ) : (
          <div className="flex h-full w-full items-center justify-center font-display text-sm text-secondary">
            Desa Puraseda
          </div>
        )}
        <span className="absolute left-3 top-3 flex items-center gap-1.5 rounded-badge bg-primary px-2.5 py-1 font-display text-xs font-semibold text-on-primary">
          <MapPin className="h-3.5 w-3.5" /> {destination.hamletName}
        </span>
      </div>
      <div className="flex flex-1 flex-col gap-2 p-5">
        <h3 className="font-display text-lg font-semibold text-ink group-hover:text-primary">{destination.name}</h3>
        <p className="line-clamp-2 text-sm text-body">{destination.shortDescription}</p>
        <span className="mt-auto pt-2 font-display text-sm font-semibold text-primary">Lihat Detail →</span>
      </div>
    </Link>
  );
}
