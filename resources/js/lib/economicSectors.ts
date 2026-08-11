import { Fish, HardHat, Scissors, Shirt, ShoppingBasket, UtensilsCrossed, Wheat, Wrench, type LucideIcon } from 'lucide-react';

export type EconomicSector =
  | 'makanan_minuman'
  | 'warung_sembako'
  | 'pertanian'
  | 'peternakan_perikanan'
  | 'toko_bangunan'
  | 'jasa_servis'
  | 'kerajinan_tangan'
  | 'pakaian_fashion';

export const SECTOR_ICONS: Record<EconomicSector, LucideIcon> = {
  makanan_minuman: UtensilsCrossed,
  warung_sembako: ShoppingBasket,
  pertanian: Wheat,
  peternakan_perikanan: Fish,
  toko_bangunan: HardHat,
  jasa_servis: Wrench,
  kerajinan_tangan: Scissors,
  pakaian_fashion: Shirt,
};

export function sectorIcon(sector: string): LucideIcon {
  return SECTOR_ICONS[sector as EconomicSector] ?? UtensilsCrossed;
}
