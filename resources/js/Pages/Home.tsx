import { Head } from '@inertiajs/react';
import { Home as HomeIcon, Landmark, Mountain, Users } from 'lucide-react';
import ArticleCard from '@/Components/ArticleCard';
import Button from '@/Components/Button';
import StatCard from '@/Components/StatCard';
import PublicLayout from '@/Layouts/PublicLayout';
import { formatNumber } from '@/lib/format';
import type { HomeProps } from '@/types';

export default function Home({ hero, villageHead, stats, latestArticles }: HomeProps) {
  return (
    <PublicLayout>
      <Head title="Beranda" />

      {/* Hero */}
      <section className="relative flex min-h-[70vh] items-end overflow-hidden bg-primary">
        {hero.imageUrl && (
          <img
            src={hero.imageUrl}
            alt=""
            className="absolute inset-0 h-full w-full object-cover"
            loading="eager"
            fetchPriority="high"
          />
        )}
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
            <Button href={hero.ctaSecondary.url} variant="secondary" className="border-white text-white hover:bg-white/10">
              {hero.ctaSecondary.label}
            </Button>
          </div>
        </div>
      </section>

      {/* Sambutan Kepala Desa */}
      {villageHead && (
        <section className="bg-background-alt py-section-mobile md:py-section-desktop">
          <div className="mx-auto max-w-container px-4 md:px-6">
            <div className="flex flex-col gap-8 rounded-card border-l-4 border-primary bg-surface p-8 md:flex-row md:items-center md:p-12">
              {villageHead.photoUrl && (
                <img
                  src={villageHead.photoUrl}
                  alt={villageHead.name}
                  className="h-32 w-32 flex-shrink-0 rounded-card object-cover md:h-40 md:w-40"
                />
              )}
              <div className="flex flex-col gap-4">
                <h2 className="font-display text-xl font-semibold text-ink">Pesan Kepala Desa</h2>
                <p className="font-display text-lg italic leading-relaxed text-body md:text-xl">
                  &ldquo;{villageHead.message}&rdquo;
                </p>
                <div>
                  <p className="font-display text-sm font-semibold text-ink">{villageHead.name}</p>
                  <p className="text-sm text-muted">{villageHead.position}</p>
                </div>
              </div>
            </div>
          </div>
        </section>
      )}

      {/* Statistik */}
      {stats && (
        <section className="bg-background py-section-mobile md:py-section-desktop">
          <div className="mx-auto grid max-w-container grid-cols-2 gap-4 px-4 md:grid-cols-4 md:gap-6 md:px-6">
            <StatCard icon={Users} value={`${formatNumber(stats.population)}+`} label="Penduduk" />
            <StatCard icon={HomeIcon} value={`${formatNumber(stats.families)}+`} label="Kepala Keluarga" />
            <StatCard icon={Landmark} value={String(stats.hamlets)} label="Dusun" />
            <StatCard icon={Mountain} value={`${stats.areaSize} ${stats.areaUnit}`} label="Wilayah" />
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
