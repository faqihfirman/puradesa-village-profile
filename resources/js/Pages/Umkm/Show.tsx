import { Head, Link } from '@inertiajs/react';
import { MapPin } from 'lucide-react';
import EconomicPotentialCard from '@/Components/EconomicPotentialCard';
import PublicLayout from '@/Layouts/PublicLayout';
import { sectorIcon } from '@/lib/economicSectors';
import type { UmkmShowProps } from '@/types';

export default function UmkmShow({ potential, related }: UmkmShowProps) {
  const SectorIcon = sectorIcon(potential.sector);

  return (
    <PublicLayout>
      <Head title={potential.title} />

      <article className="bg-background-alt pb-section-mobile pt-10 md:pb-section-desktop md:pt-14">
        <div className="mx-auto max-w-container px-4 md:px-6">
          <nav className="flex flex-wrap items-center gap-1.5 text-sm text-muted">
            <Link href="/" className="hover:text-primary">Beranda</Link>
            <span>›</span>
            <Link href="/umkm" className="hover:text-primary">UMKM</Link>
            <span>›</span>
            <span className="text-body">{potential.title}</span>
          </nav>

          <div className="mx-auto max-w-3xl">
            <div className="relative mt-6 max-h-[480px] w-full overflow-hidden rounded-card">
              {potential.imageUrl ? (
                <img src={potential.imageUrl} alt={potential.title} className="h-full max-h-[480px] w-full object-cover" loading="eager" />
              ) : (
                <div className="flex aspect-[16/9] h-full max-h-[480px] w-full items-center justify-center bg-secondary-container font-display text-sm text-secondary">
                  Desa Puraseda
                </div>
              )}
              <span className="absolute left-4 top-4 flex items-center gap-1.5 rounded-badge bg-primary px-2.5 py-1 font-display text-xs font-semibold text-on-primary">
                <SectorIcon className="h-3.5 w-3.5" /> {potential.sectorLabel}
              </span>
            </div>

            <h1 className="mt-6 font-display text-3xl font-bold text-ink md:text-4xl">{potential.title}</h1>

            <p className="mt-8 whitespace-pre-line text-body md:text-lg md:leading-relaxed">{potential.content}</p>

            {potential.mapsUrl && (
              <div className="mt-10 flex items-center gap-3 border-t border-border pt-6">
                <a
                  href={potential.mapsUrl}
                  target="_blank"
                  rel="noreferrer"
                  className="inline-flex items-center gap-2 rounded-button bg-primary px-6 py-3 font-display text-sm font-semibold text-on-primary transition-colors hover:bg-primary-hover"
                >
                  <MapPin className="h-4 w-4" /> Lihat Lokasi
                </a>
              </div>
            )}
          </div>
        </div>
      </article>

      {related.length > 0 && (
        <section className="bg-background py-section-mobile md:py-section-desktop">
          <div className="mx-auto max-w-container px-4 md:px-6">
            <h2 className="font-display text-2xl font-semibold text-ink md:text-3xl">UMKM Lainnya</h2>
            <div className="mt-8 grid gap-6 md:grid-cols-3">
              {related.map((item) => (
                <EconomicPotentialCard key={item.slug} potential={item} />
              ))}
            </div>
          </div>
        </section>
      )}
    </PublicLayout>
  );
}
