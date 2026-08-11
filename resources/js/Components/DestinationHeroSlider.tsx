import { Link } from '@inertiajs/react';
import { MapPin } from 'lucide-react';
import { useEffect, useState } from 'react';
import type { DestinationCard } from '@/types';

const SLIDE_INTERVAL_MS = 3000;

export default function DestinationHeroSlider({ slides }: { slides: DestinationCard[] }) {
  const [activeIndex, setActiveIndex] = useState(0);

  useEffect(() => {
    if (slides.length <= 1) return;

    const timer = setInterval(() => {
      setActiveIndex((current) => (current + 1) % slides.length);
    }, SLIDE_INTERVAL_MS);

    return () => clearInterval(timer);
  }, [slides.length]);

  if (slides.length === 0) return null;

  return (
    <div className="relative mt-10 min-h-[420px] overflow-hidden rounded-card">
      {slides.map((slide, index) => (
        <Link
          key={slide.slug}
          href={`/potensi-wisata/${slide.slug}`}
          className={`group absolute inset-0 flex items-end transition-opacity duration-700 ${
            index === activeIndex ? 'opacity-100' : 'pointer-events-none opacity-0'
          }`}
        >
          {slide.coverUrl ? (
            <>
              <img
                src={slide.coverUrl}
                alt={slide.name}
                className="absolute inset-0 h-full w-full object-cover transition-transform group-hover:scale-105"
                loading={index === 0 ? 'eager' : 'lazy'}
              />
              <div className="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/30 to-transparent" />
            </>
          ) : (
            <div className="absolute inset-0 bg-gradient-to-br from-primary to-primary-hover" />
          )}

          <div className="relative flex flex-col gap-3 p-6 md:p-10">
            <span className="flex w-fit items-center gap-1.5 rounded-badge bg-accent px-2.5 py-1 font-display text-xs font-semibold uppercase tracking-wider text-on-accent">
              <MapPin className="h-3.5 w-3.5" /> {slide.hamletName}
            </span>
            <h2 className="max-w-2xl font-display text-2xl font-bold text-white md:text-4xl">{slide.name}</h2>
            <p className="max-w-xl text-sm text-white/90 md:text-base">{slide.shortDescription}</p>
          </div>
        </Link>
      ))}

      {slides.length > 1 && (
        <div className="absolute bottom-4 right-4 flex gap-1.5 md:bottom-6 md:right-6">
          {slides.map((slide, index) => (
            <button
              key={slide.slug}
              type="button"
              onClick={() => setActiveIndex(index)}
              aria-label={`Ke slide ${slide.name}`}
              className={`h-2 rounded-full transition-all ${
                index === activeIndex ? 'w-6 bg-white' : 'w-2 bg-white/50 hover:bg-white/75'
              }`}
            />
          ))}
        </div>
      )}
    </div>
  );
}
