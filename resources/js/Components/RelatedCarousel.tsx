import { Link } from '@inertiajs/react';
import { MapPin } from 'lucide-react';
import type { ReactNode } from 'react';

export type RelatedItem = {
  key: string;
  href: string;
  imageUrl: string | null;
  title: string;
  subtitle?: string | null;
  badge?: string | null;
};

export default function RelatedCarousel({ title, items }: { title: string; items: RelatedItem[] }): ReactNode {
  if (items.length === 0) return null;

  return (
    <section className="bg-background py-section-mobile md:py-section-desktop">
      <div className="mx-auto max-w-container px-4 md:px-6">
        <h2 className="font-display text-2xl font-semibold text-ink md:text-3xl">{title}</h2>

        <div className="mt-8 flex gap-6 overflow-x-auto pb-4">
          {items.map((item) => (
            <Link
              key={item.key}
              href={item.href}
              className="group flex w-72 flex-shrink-0 flex-col overflow-hidden rounded-card border border-border bg-surface transition-colors hover:border-secondary"
            >
              <div className="relative aspect-[16/9] w-full overflow-hidden bg-secondary-container">
                {item.imageUrl ? (
                  <img src={item.imageUrl} alt={item.title} className="h-full w-full object-cover" loading="lazy" />
                ) : (
                  <div className="flex h-full w-full items-center justify-center font-display text-sm text-secondary">
                    Desa Puraseda
                  </div>
                )}
                {item.badge && (
                  <span className="absolute left-3 top-3 rounded-badge bg-primary px-2.5 py-1 font-display text-xs font-semibold text-on-primary">
                    {item.badge}
                  </span>
                )}
              </div>
              <div className="flex flex-1 flex-col gap-2 p-4">
                <h3 className="font-display text-base font-semibold text-ink group-hover:text-primary">{item.title}</h3>
                {item.subtitle && (
                  <p className="flex items-center gap-1 text-sm text-muted">
                    <MapPin className="h-3.5 w-3.5" /> {item.subtitle}
                  </p>
                )}
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
}
