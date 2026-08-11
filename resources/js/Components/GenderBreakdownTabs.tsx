import { useState } from 'react';
import { formatNumber } from '@/lib/format';
import type { PopulationByGender } from '@/types';

type Tab = { key: string; label: string; rows: PopulationByGender[] };

function GenderRow({ label, male, female, total }: { label: string; male: number; female: number; total: number }) {
  const malePercent = total > 0 ? (male / total) * 100 : 0;
  const femalePercent = total > 0 ? (female / total) * 100 : 0;

  return (
    <div className="grid grid-cols-1 gap-2 border-b border-border py-3 last:border-0 sm:grid-cols-[1fr_2fr_1fr] sm:items-center sm:gap-4">
      <span className="font-display text-sm font-medium text-ink sm:text-center">{label}</span>

      <div className="flex flex-col gap-1.5">
        <div className="flex items-center gap-2">
          <span className="w-16 shrink-0 text-xs text-muted">Laki-laki</span>
          <div className="h-2.5 flex-1 overflow-hidden rounded-full bg-surface-dim">
            <div className="h-full rounded-full bg-primary" style={{ width: `${malePercent}%` }} />
          </div>
          <span className="w-12 shrink-0 text-right text-xs font-semibold text-ink">{formatNumber(male)}</span>
        </div>
        <div className="flex items-center gap-2">
          <span className="w-16 shrink-0 text-xs text-muted">Perempuan</span>
          <div className="h-2.5 flex-1 overflow-hidden rounded-full bg-surface-dim">
            <div className="h-full rounded-full bg-secondary" style={{ width: `${femalePercent}%` }} />
          </div>
          <span className="w-12 shrink-0 text-right text-xs font-semibold text-ink">{formatNumber(female)}</span>
        </div>
      </div>

      <span className="text-xs text-muted sm:text-right">{formatNumber(male + female)} jiwa</span>
    </div>
  );
}

export default function GenderBreakdownTabs({ tabs, total }: { tabs: Tab[]; total: number }) {
  const visibleTabs = tabs.filter((tab) => tab.rows.length > 0);
  const [active, setActive] = useState(visibleTabs[0]?.key);

  if (visibleTabs.length === 0) return null;

  const activeTab = visibleTabs.find((tab) => tab.key === active) ?? visibleTabs[0];

  return (
    <div className="rounded-card border border-border bg-surface p-6 md:p-8">
      <div className="border-b border-border pb-4 sm:hidden">
        <select
          value={activeTab.key}
          onChange={(e) => setActive(e.target.value)}
          className="w-full rounded-input border border-secondary/30 bg-background px-4 py-2.5 font-display text-sm font-semibold text-ink focus:border-2 focus:border-primary focus:outline-none"
        >
          {visibleTabs.map((tab) => (
            <option key={tab.key} value={tab.key}>
              {tab.label}
            </option>
          ))}
        </select>
      </div>

      <div className="hidden flex-wrap gap-2 border-b border-border pb-4 sm:flex">
        {visibleTabs.map((tab) => (
          <button
            key={tab.key}
            type="button"
            onClick={() => setActive(tab.key)}
            className={`rounded-button px-4 py-2 font-display text-sm font-semibold transition-colors ${
              activeTab.key === tab.key ? 'bg-primary text-on-primary' : 'bg-surface-dim text-body hover:text-ink'
            }`}
          >
            {tab.label}
          </button>
        ))}
      </div>

      <div className="mt-2">
        {activeTab.rows.map((row) => (
          <GenderRow key={row.label} label={row.label} male={row.male} female={row.female} total={total} />
        ))}
      </div>
    </div>
  );
}
