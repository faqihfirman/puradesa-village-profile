import { formatNumber } from '@/lib/format';

export default function PopulationBar({
  label,
  value,
  total,
  colorClass = 'bg-primary',
}: {
  label: string;
  value: number;
  total: number;
  colorClass?: string;
}) {
  const percent = total > 0 ? (value / total) * 100 : 0;

  return (
    <div className="flex flex-col gap-1.5 sm:flex-row sm:items-center sm:gap-4">
      <span className="w-full font-display text-sm font-medium text-ink sm:w-40 sm:shrink-0">{label}</span>
      <div className="flex flex-1 items-center gap-3">
        <div className="h-3 w-full overflow-hidden rounded-full bg-surface-dim">
          <div className={`h-full rounded-full ${colorClass}`} style={{ width: `${percent}%` }} />
        </div>
        <span className="w-28 shrink-0 text-right font-display text-sm font-semibold text-ink">
          {formatNumber(value)} <span className="font-normal text-muted">({percent.toFixed(1)}%)</span>
        </span>
      </div>
    </div>
  );
}
