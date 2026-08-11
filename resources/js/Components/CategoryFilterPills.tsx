import { router } from '@inertiajs/react';
import type { Category } from '@/types';

type Props = {
  categories: Category[];
  active: string | null;
};

export default function CategoryFilterPills({ categories, active }: Props) {
  const go = (slug: string | null) => {
    router.get(
      '/artikel',
      slug ? { kategori: slug } : {},
      { only: ['articles', 'activeCategory'], preserveScroll: true, preserveState: true }
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
      {categories.map((category) => (
        <button
          key={category.slug}
          type="button"
          onClick={() => go(category.slug)}
          className={`rounded-full px-3 py-1.5 font-display text-xs font-semibold transition-colors ${
            active === category.slug ? 'bg-primary text-on-primary' : 'bg-surface text-body hover:bg-secondary-container'
          }`}
        >
          {category.name}
        </button>
      ))}
    </div>
  );
}
