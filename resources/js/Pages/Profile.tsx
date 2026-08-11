import { Head } from '@inertiajs/react';
import { Gauge, Home, Landmark, Mountain, Ruler, Users } from 'lucide-react';
import GenderBreakdownTabs from '@/Components/GenderBreakdownTabs';
import OfficialCard from '@/Components/OfficialCard';
import PopulationBar from '@/Components/PopulationBar';
import VillageMap from '@/Components/VillageMap';
import PublicLayout from '@/Layouts/PublicLayout';
import { formatNumber } from '@/lib/format';
import type { ProfileProps } from '@/types';

const LEVEL_LABELS: Record<number, string> = {
  2: 'Sekretaris Desa',
  3: 'Kaur & Kasi',
  4: 'Kepala Dusun',
};

export default function Profile({ profile, missions, officials }: ProfileProps) {
  const villageHead = officials.find((o) => o.level === 1);
  const otherOfficials = officials.filter((o) => o.level !== 1);
  const officialsByLevel = otherOfficials.reduce<Record<number, typeof officials>>((acc, official) => {
    (acc[official.level] ??= []).push(official);
    return acc;
  }, {});

  return (
    <PublicLayout>
      <Head title="Profil Desa" />

      <div className="bg-background-alt pb-10 pt-10 md:pt-14">
        <div className="mx-auto max-w-2xl px-4 text-center md:px-6">
          <h1 className="font-display text-3xl font-bold text-ink md:text-5xl">Profil Desa Puraseda</h1>
          <p className="mt-4 text-body">Mengenal lebih dekat sejarah, visi misi, dan data wilayah Desa Puraseda.</p>
        </div>
      </div>

      {/* Sejarah Desa */}
      <section className="bg-background py-section-mobile md:py-section-desktop">
        <div className="mx-auto grid max-w-container gap-10 px-4 md:grid-cols-2 md:items-center md:gap-14 md:px-6">
          <div>
            <h2 className="font-display text-2xl font-semibold text-ink md:text-3xl">Sejarah Desa</h2>
            <div className="article-body mt-5 text-body" dangerouslySetInnerHTML={{ __html: profile.historyContent }} />
          </div>

          <div className="relative">
            <div className="aspect-square w-full overflow-hidden rounded-card border border-border bg-surface-dim">
              {profile.illustrationUrl ? (
                <img
                  src={profile.illustrationUrl}
                  alt="Ilustrasi wilayah Desa Puraseda"
                  className="h-full w-full object-cover"
                  loading="lazy"
                />
              ) : (
                <div className="flex h-full w-full items-center justify-center">
                  <Mountain className="h-24 w-24 text-secondary" strokeWidth={1.25} />
                </div>
              )}
            </div>

            <div className="absolute -bottom-5 left-6 flex items-center gap-3 rounded-card bg-primary px-4 py-3 shadow-sm md:left-8">
              <span className="flex h-9 w-9 shrink-0 items-center justify-center rounded-input bg-on-primary/10">
                <Landmark className="h-5 w-5 text-on-primary" />
              </span>
              <div className="text-left">
                <p className="font-display text-[11px] font-semibold uppercase tracking-wider text-on-primary/70">Didirikan</p>
                <p className="font-display text-lg font-bold leading-none text-on-primary">{profile.foundedYear}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Visi & Misi */}
      <section className="bg-background-alt py-section-mobile md:py-section-desktop">
        <div className="mx-auto grid max-w-container gap-10 px-4 md:grid-cols-2 md:gap-14 md:px-6">
          <div>
            <h2 className="font-display text-2xl font-semibold text-ink md:text-3xl">Visi</h2>
            <blockquote className="mt-4 border-l-4 border-primary pl-5 font-display text-base font-medium leading-relaxed text-ink md:text-lg">
              &ldquo;{profile.vision}&rdquo;
            </blockquote>
          </div>

          <div>
            <h2 className="font-display text-2xl font-semibold text-ink md:text-3xl">Misi</h2>
            <ol className="mt-5 space-y-5">
              {missions.map((mission, i) => (
                <li key={mission.title} className="flex gap-4">
                  <span className="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary font-display text-sm font-semibold text-on-primary">
                    {i + 1}
                  </span>
                  <div>
                    <p className="font-display text-base font-semibold text-ink">{mission.title}</p>
                    <p className="mt-1 text-sm text-body">{mission.description}</p>
                  </div>
                </li>
              ))}
            </ol>
          </div>
        </div>
      </section>

      {/* Data Wilayah */}
      <section className="bg-background py-section-mobile md:py-section-desktop">
        <div className="mx-auto max-w-container px-4 md:px-6">
          <h2 className="font-display text-2xl font-semibold text-ink md:text-3xl">Data Wilayah</h2>
          <p className="mt-2 text-body">Kondisi umum wilayah dan sebaran penduduk Desa Puraseda.</p>

          <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div className="rounded-card border border-border bg-surface p-5">
              <span className="flex h-10 w-10 items-center justify-center rounded-input bg-primary">
                <Ruler className="h-5 w-5 text-on-primary" />
              </span>
              <p className="mt-3 font-display text-xs font-semibold uppercase tracking-wider text-muted">Luas Wilayah</p>
              <p className="font-display text-3xl font-bold text-accent">
                {formatNumber(profile.areaSize)} <span className="text-lg font-semibold text-muted">{profile.areaUnit}</span>
              </p>
            </div>

            <div className="rounded-card border border-border bg-surface p-5">
              <span className="flex h-10 w-10 items-center justify-center rounded-input bg-primary">
                <Home className="h-5 w-5 text-on-primary" />
              </span>
              <p className="mt-3 font-display text-xs font-semibold uppercase tracking-wider text-muted">Jumlah Keluarga</p>
              <p className="font-display text-3xl font-bold text-accent">{formatNumber(profile.totalFamilies)}</p>
            </div>

            <div className="rounded-card border border-border bg-surface p-5">
              <span className="flex h-10 w-10 items-center justify-center rounded-input bg-primary">
                <Users className="h-5 w-5 text-on-primary" />
              </span>
              <p className="mt-3 font-display text-xs font-semibold uppercase tracking-wider text-muted">Jumlah Penduduk</p>
              <p className="font-display text-3xl font-bold text-accent">{formatNumber(profile.totalPopulation)}</p>
            </div>

            <div className="rounded-card border border-border bg-surface p-5">
              <span className="flex h-10 w-10 items-center justify-center rounded-input bg-primary">
                <Gauge className="h-5 w-5 text-on-primary" />
              </span>
              <p className="mt-3 font-display text-xs font-semibold uppercase tracking-wider text-muted">Kepadatan Penduduk</p>
              <p className="font-display text-3xl font-bold text-accent">
                {formatNumber(profile.populationDensity)} <span className="text-lg font-semibold text-muted">Jiwa/{profile.areaUnit}</span>
              </p>
            </div>
          </div>

          <div className="mt-8">
            <VillageMap lat={profile.mapCenterLat} lng={profile.mapCenterLng} zoom={profile.mapZoom} className="min-h-[320px] w-full" />
          </div>

          {(profile.populationByReligion.length > 0 || profile.populationByMaritalStatus.length > 0) && (
            <div className="mt-8 grid gap-8 md:grid-cols-2">
              {profile.populationByReligion.length > 0 && (
                <div className="rounded-card border border-border bg-surface p-6 md:p-8">
                  <h3 className="font-display text-lg font-semibold text-ink">Penduduk Berdasarkan Agama</h3>
                  <div className="mt-5 space-y-4">
                    {profile.populationByReligion.map((row) => (
                      <PopulationBar key={row.label} label={row.label} value={row.total} total={profile.totalPopulation} colorClass="bg-primary" />
                    ))}
                  </div>
                </div>
              )}

              {profile.populationByMaritalStatus.length > 0 && (
                <div className="rounded-card border border-border bg-surface p-6 md:p-8">
                  <h3 className="font-display text-lg font-semibold text-ink">Penduduk Berdasarkan Status Perkawinan</h3>
                  <div className="mt-5 space-y-4">
                    {profile.populationByMaritalStatus.map((row) => (
                      <PopulationBar
                        key={row.label}
                        label={row.label}
                        value={row.total}
                        total={profile.totalPopulation}
                        colorClass="bg-secondary"
                      />
                    ))}
                  </div>
                </div>
              )}
            </div>
          )}

          <div className="mt-8">
            <GenderBreakdownTabs
              total={profile.totalPopulation}
              tabs={[
                { key: 'pendidikan', label: 'Pendidikan Penduduk', rows: profile.populationByEducation },
                { key: 'pekerjaan', label: 'Pekerjaan Penduduk', rows: profile.populationByOccupation },
                { key: 'usia', label: 'Usia Penduduk', rows: profile.populationByAgeGroup },
              ]}
            />
          </div>
        </div>
      </section>

      {/* Struktur Organisasi (SOTK) */}
      {officials.length > 0 && (
        <section className="bg-background py-section-mobile md:py-section-desktop">
          <div className="mx-auto max-w-container px-4 md:px-6">
            <h2 className="text-center font-display text-2xl font-semibold text-ink md:text-3xl">Struktur Organisasi</h2>
            <p className="mx-auto mt-2 max-w-xl text-center text-body">Susunan perangkat Desa Puraseda yang menjalankan roda pemerintahan.</p>

            <div className="mt-10 flex flex-col items-center gap-10">
              {villageHead && (
                <div className="w-52">
                  <OfficialCard official={villageHead} size="lg" />
                </div>
              )}

              {[2, 3, 4].map((level) =>
                officialsByLevel[level]?.length ? (
                  <div key={level} className="w-full">
                    <h3 className="text-center font-display text-sm font-semibold uppercase tracking-wider text-muted">
                      {LEVEL_LABELS[level]}
                    </h3>
                    <div className="mx-auto mt-5 grid max-w-3xl grid-cols-2 gap-5 md:grid-cols-4">
                      {officialsByLevel[level].map((official) => (
                        <OfficialCard key={official.name} official={official} />
                      ))}
                    </div>
                  </div>
                ) : null,
              )}
            </div>
          </div>
        </section>
      )}
    </PublicLayout>
  );
}
