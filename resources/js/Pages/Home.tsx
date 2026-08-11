import { Head } from '@inertiajs/react';
import heroPhoto from '@/assets/homepage/hero-section.jpg';
import villageHeadPhoto from '@/assets/homepage/asep-ruhiyat.jpg';
import ArticleCard from '@/Components/ArticleCard';
import Button from '@/Components/Button';
import VillageCalendar from '@/Components/VillageCalendar';
import PublicLayout from '@/Layouts/PublicLayout';
import type { HomeProps } from '@/types';

export default function Home({ hero, villageHead, events, latestArticles }: HomeProps) {
  return (
    <PublicLayout>
      <Head title="Beranda" />

      {/* Hero */}
      <section className="relative flex min-h-[70vh] items-end overflow-hidden bg-primary">
        <img src={heroPhoto} alt="" aria-hidden="true" className="absolute inset-0 h-full w-full object-cover" />
        <div className="absolute inset-0 bg-primary/40" />

        <div className="relative mx-auto w-full max-w-container px-4 pb-16 md:px-6">
          <h1 className="max-w-2xl font-display text-4xl font-bold leading-tight text-white md:text-6xl md:leading-[1.1]">
            {hero.title}
          </h1>
          <p className="mt-4 max-w-xl text-base text-white/90 md:text-lg">{hero.subtitle}</p>
          <div className="mt-8 flex flex-wrap gap-4">
            <Button href={hero.ctaPrimary.url} variant="accent">
              {hero.ctaPrimary.label}
            </Button>
          </div>
        </div>

        <svg
          className="absolute inset-x-0 bottom-0 h-16 w-full text-background-alt md:h-24"
          viewBox="0 0 1200 96"
          preserveAspectRatio="none"
          aria-hidden="true"
        >
          <path d="M0,64 C300,112 900,16 1200,64 L1200,96 L0,96 Z" fill="currentColor" />
        </svg>
      </section>

      {/* Sambutan Kepala Desa */}
      {villageHead && (
        <section className="bg-background-alt py-section-mobile md:py-section-desktop">
          <div className="mx-auto max-w-container px-4 md:px-6">
            <h2 className="font-display text-2xl font-semibold text-ink md:text-3xl">Sambutan Kepala Desa</h2>

            <div className="mt-8 grid gap-8 border-l-4 border-primary pl-6 md:grid-cols-[220px_1fr] md:gap-10 md:pl-10">
              <img
                src={villageHead.photoUrl ?? villageHeadPhoto}
                alt={`${villageHead.name}, ${villageHead.position} Desa Puraseda`}
                width={220}
                height={220}
                loading="lazy"
                className="aspect-square w-36 rounded-input object-cover object-top md:w-full"
              />

              <div className="flex flex-col">
                <blockquote className="max-w-2xl font-display text-lg leading-relaxed text-body md:text-xl md:leading-relaxed">
                  &ldquo;{villageHead.message}&rdquo;
                </blockquote>

                <div className="mt-6 border-t border-border pt-4 md:mt-auto">
                  <p className="font-display text-base font-semibold text-ink">{villageHead.name}</p>
                  <p className="text-sm text-muted">{villageHead.position} Desa Puraseda</p>
                </div>
              </div>
            </div>
          </div>
        </section>
      )}

      {/* Kalender Desa */}
      {events.length > 0 && (
        <section className="bg-background py-section-mobile md:py-section-desktop">
          <div className="mx-auto max-w-container px-4 md:px-6">
            <h2 className="font-display text-2xl font-semibold text-ink md:text-3xl">Kalender Desa</h2>
            <div className="mt-8">
              <VillageCalendar events={events} />
            </div>
          </div>
        </section>
      )}

      {/* Kabar Desa Terkini */}
      {latestArticles.length > 0 && (
        <section className="bg-background-alt py-section-mobile md:py-section-desktop">
          <div className="mx-auto max-w-container px-4 md:px-6">
            <div className="flex flex-col justify-between gap-4 md:flex-row md:items-end">
              <div>
                <h2 className="font-display text-2xl font-semibold text-ink md:text-3xl">Kabar Desa Terkini</h2>
                <p className="mt-2 max-w-xl text-body">
                  Ikuti perkembangan terbaru, program kerja, dan cerita inspiratif dari warga {`Desa Puraseda`}.
                </p>
              </div>
              <Button href="/artikel" variant="secondary">
                Semua Berita →
              </Button>
            </div>

            <div className="mt-10 grid gap-6 md:grid-cols-3">
              {latestArticles.map((article) => (
                <ArticleCard key={article.slug} article={article} />
              ))}
            </div>
          </div>
        </section>
      )}
    </PublicLayout>
  );
}
