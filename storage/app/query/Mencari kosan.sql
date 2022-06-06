SELECT 
DISTINCT
	k.*,
	harga.min as hargamin,
	harga.max as hargamax,
	count(kk.id) as jumlahkamar,
	foto.nama
FROM 
	public.kosan as k,
	public.kamar_kosan as kk,
	(select
		max(harga) as max,
		min(harga) as min,
		idkosan
	from 
		public.kamar_kosan
	group by 
		idkosan) as harga,
	(select
		max(foto.nama) as nama
	from
		public.foto,
		public.foto_kosan,
		public.kosan
	where
		foto_kosan.idfoto = foto.id AND
		kosan.id = foto_kosan.idkosan
	GROUP BY
		kosan.id) as foto
WHERE
	k.terverifikasi = false AND
	kk.idkosan = k.id
GROUP BY
	k.id,
	harga.max,
	harga.min,
	foto.nama
	