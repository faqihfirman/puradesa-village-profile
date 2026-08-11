import { router } from '@inertiajs/react';
import type { SectorOption } from '@/types';

type Props = {
  sectors: SectorOption[];
  active: string | null;
};

export default function SectorFilterPills({ sectors, active }: Props) {
  const go = (value: string | null) => {
    router.get(
      '/umkm',
      value ? { sektor: value } : {},
      { only: ['potentials', 'activeSector'], preserveScroll: true, preserveState: true }
    );
  };

  return (
    <div className="flex flex-wrap gap-2">
      <button
        type="button"
        onClick={() => go(null)}
        className={`rounded-full px-3 py-1.5 font-display text-xs font-semibold transition-colors ${
          !active ? 'bg-primary text-on-primary' : 'bg-surface text-body hover:bg-secondary-container'
        }`}
      >
        Semua
      </button>
      {sectors.map((sector) => (
        <button
          key={sector.value}
          type="button"
          onClick={() => go(sector.value)}
          className={`rounded-full px-3 py-1.5 font-display text-xs font-semibold transition-colors ${
            active === sector.value ? 'bg-primary text-on-primary' : 'bg-surface text-body hover:bg-secondary-container'
          }`}
        >
          {sector.label}
        </button>
      ))}
    </div>
  );
}
