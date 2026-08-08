import type { LucideIcon } from 'lucide-react';

type StatCardProps = {
  icon: LucideIcon;
  value: string;
  label: string;
};

export default function StatCard({ icon: Icon, value, label }: StatCardProps) {
  return (
    <div className="flex flex-col items-center gap-3 rounded-card border border-border bg-surface px-6 py-8 text-center">
      <span className="flex h-14 w-14 items-center justify-center rounded-full bg-secondary-container">
        <Icon className="h-7 w-7 text-primary" strokeWidth={2} />
      </span>
      <span className="font-display text-4xl font-bold text-accent">{value}</span>
      <span className="font-display text-xs font-semibold uppercase tracking-wider text-muted">{label}</span>
    </div>
  );
}
