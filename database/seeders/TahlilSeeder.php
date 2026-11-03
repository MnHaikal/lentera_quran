<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\TahlilItem;
use Illuminate\Database\Seeder;

class TahlilSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'urutan' => 1,
                'judul' => 'Pengantar Al-Fatihah kepada Rasulullah SAW (Tawassul)',
                'teks_arab' => 'إِلَى حَضْرَةِ النَّبِيِّ الْمُصْطَفَى مُحَمَّدٍ صَلَّى اللهُ عَلَيْهِ وَسَلَّمَ وَآلِهِ وَصَحْبِهِ أَجْمَعِيْنَ، شَيْءٌ لِلّٰهِ لَهُمُ الْفَاتِحَةُ',
                'teks_latin' => "Ilaa hadhratin-nabiyyil-musthafaa Muhammadin shallallahu 'alaihi wa sallama wa aalihii wa shahbihii ajma'iin, syai-un lillaahi lahumul-faatihah.",
                'terjemahan' => 'Kepada yang mulia Nabi pilihan Muhammad SAW beserta keluarga dan seluruh sahabat beliau, sesuatu karena Allah untuk mereka, bacaan Al-Fatihah.',
                'jumlah_baca' => 1,
                'keterangan' => 'Dibaca 1 kali sebagai pembuka tahlil',
                'is_published' => true,
            ],
            [
                'urutan' => 2,
                'judul' => 'Surah Al-Fatihah',
                'teks_arab' => 'بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ ۝١ اَلْحَمْدُ لِلّٰهِ رَبِّ الْعٰلَمِيْنَۙ ۝٢ الرَّحْمٰنِ الرَّحِيْمِۙ ۝٣ مٰلِكِ يَوْمِ الدِّيْنِۗ ۝٤ اِيَّاكَ نَعْبُدُ وَاِيَّاكَ نَسْتَعِيْنُۗ ۝٥ اِهْدِنَا الصِّرَاطَ الْمُسْتَقِيْمَۙ ۝٦ صِرَاطَ الَّذِيْنَ اَنْعَمْتَ عَلَيْهِمْ ەۙ غَيْرِ الْمَغْضُوْبِ عَلَيْهِمْ وَلَا الضَّاۤلِّيْنَ ࣖ ۝٧',
                'teks_latin' => "Bismillaahir-rahmaanir-rahiim. Al-hamdu lillaahi rabbil-'aalamiin. Ar-rahmaanir-rahiim. Maaliki yaumid-diin. Iyyaaka na'budu wa iyyaaka nasta'iin. Ihdinash-shiraathal-mustaqiim. Shiraathal-ladziina an'amta 'alaihim ghairil-maghdhuubi 'alaihim wa ladh-dhaalliin.",
                'terjemahan' => 'Dengan nama Allah Yang Maha Pengasih lagi Maha Penyayang. Segala puji bagi Allah, Tuhan semesta alam. Yang Maha Pengasih lagi Maha Penyayang. Pemilik hari Pembalasan. Hanya kepada Engkaulah kami menyembah dan hanya kepada Engkaulah kami memohon pertolongan. Bimbinglah kami ke jalan yang lurus, (yaitu) jalan orang-orang yang telah Engkau beri nikmat, bukan (jalan) mereka yang dimurkai dan bukan (pula jalan) orang-orang yang sesat.',
                'jumlah_baca' => 1,
                'keterangan' => 'Surah pembuka Al-Qur\'an',
                'is_published' => true,
            ],
            [
                'urutan' => 3,
                'judul' => 'Surah Al-Ikhlas',
                'teks_arab' => 'بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ. قُلْ هُوَ اللّٰهُ اَحَدٌۚ ۝١ اَللّٰهُ الصَّمَدُۚ ۝٢ لَمْ يَلِدْ وَلَمْ يُوْلَدْۙ ۝٣ وَلَمْ يَكُنْ لَّهٗ كُفُوًا اَحَدٌ ࣖ ۝٤',
                'teks_latin' => 'Bismillaahir-rahmaanir-rahiim. Qul huwallaahu ahad. Allaahush-shamad. Lam yalid wa lam yuulad. Wa lam yakul-lahuu kufuwan ahad.',
                'terjemahan' => 'Dengan nama Allah Yang Maha Pengasih lagi Maha Penyayang. Katakanlah (Muhammad), "Dialah Allah, Yang Maha Esa. Allah tempat meminta segala sesuatu. (Allah) tidak beranak dan tidak pula diperanakkan. Dan tidak ada sesuatu pun yang setara dengan Dia."',
                'jumlah_baca' => 3,
                'keterangan' => 'Dibaca 3 kali dilanjutkan tahlil dan takbir',
                'is_published' => true,
            ],
            [
                'urutan' => 4,
                'judul' => 'Tahlil & Takbir',
                'teks_arab' => 'لَا إِلٰهَ إِلَّا اللّٰهُ وَاللّٰهُ أَكْبَرُ وَلِلّٰهِ الْحَمْدُ',
                'teks_latin' => 'Laa ilaaha illallaahu wallaahu akbar wa lillaahil-hamd.',
                'terjemahan' => 'Tiada Tuhan selain Allah, Allah Maha Besar dan bagi Allah segala puji.',
                'jumlah_baca' => 1,
                'keterangan' => 'Pemisah antar surah pendek',
                'is_published' => true,
            ],
            [
                'urutan' => 5,
                'judul' => 'Surah Al-Falaq',
                'teks_arab' => 'بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ. قُلْ اَعُوْذُ بِرَبِّ الْفَلَقِۙ ۝١ مِنْ شَرِّ مَا خَلَقَۙ ۝٢ وَمِنْ شَرِّ غَاسِقٍ اِذَا وَقَبَۙ ۝٣ وَمِنْ شَرِّ النَّفّٰثٰتِ فِى الْعُقَدِۙ ۝٤ وَمِنْ شَرِّ حَاسِدٍ اِذَا حَسَدَ ࣖ ۝٥',
                'teks_latin' => 'Bismillaahir-rahmaanir-rahiim. Qul a\'uudzu birabbil-falaq. Min syarri maa khalaq. Wa min syarri ghaasiqin idzaa waqab. Wa min syarrin-naffaatsaati fil-\'uqad. Wa min syarri haasidin idzaa hasad.',
                'terjemahan' => 'Dengan nama Allah Yang Maha Pengasih lagi Maha Penyayang. Katakanlah, "Aku berlindung kepada Tuhan yang menguasai subuh (fajar), dari kejahatan (makhluk yang) Dia ciptakan, dan dari kejahatan malam apabila telah gelap gulita, dan dari kejahatan (perempuan-perempuan) penyihir yang meniup pada buhul-buhul (talinya), dan dari kejahatan orang yang dengki apabila dia dengki."',
                'jumlah_baca' => 1,
                'keterangan' => 'Dibaca 1 kali',
                'is_published' => true,
            ],
            [
                'urutan' => 6,
                'judul' => 'Surah An-Nas',
                'teks_arab' => 'بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ. قُلْ اَعُوْذُ بِرَبِّ النَّاسِۙ ۝١ مَلِكِ النَّاسِۙ ۝٢ اِلٰهِ النَّاسِۙ ۝٣ مِنْ شَرِّ الْوَسْوَاسِ ەۙ الْخَنَّاسِۖ ۝٤ الَّذِيْ يُوَسْوِسُ فِيْ صُدُوْرِ النَّاسِۙ ۝٥ مِنَ الْجِنَّةِ وَالنَّاسِ ࣖ ۝٦',
                'teks_latin' => 'Bismillaahir-rahmaanir-rahiim. Qul a\'uudzu birabbin-naas. Malikin-naas. Ilaahin-naas. Min syarril-waswaasil-khannaas. Alladzii yuwaswisu fii shuduurin-naas. Minal-jinnati wan-naas.',
                'terjemahan' => 'Dengan nama Allah Yang Maha Pengasih lagi Maha Penyayang. Katakanlah, "Aku berlindung kepada Tuhannya manusia, Raja manusia, sembahan manusia, dari kejahatan (bisikan) setan yang bersembunyi, yang membisikkan (kejahatan) ke dalam dada manusia, dari (golongan) jin dan manusia."',
                'jumlah_baca' => 1,
                'keterangan' => 'Dibaca 1 kali',
                'is_published' => true,
            ],
            [
                'urutan' => 7,
                'judul' => 'Ayat Kursi (Surah Al-Baqarah: 255)',
                'teks_arab' => 'اَللّٰهُ لَآ اِلٰهَ اِلَّا هُوَۚ اَلْحَيُّ الْقَيُّوْمُ ەۚ لَا تَأْخُذُهٗ سِنَةٌ وَّلَا نَوْمٌۗ لَهٗ مَا فِى السَّمٰوٰتِ وَمَا فِى الْاَرْضِۗ مَنْ ذَا الَّذِيْ يَشْفَعُ عِنْدَهٗٓ اِلَّا بِاِذْنِهٖۗ يَعْلَمُ مَا بَيْنَ اَيْدِيْهِمْ وَمَا خَلْفَهُمْۚ وَلَا يُحِيْطُوْنَ بِشَيْءٍ مِّنْ عِلْمِهٖٓ اِلَّا بِمَا شَاۤءَۚ وَسِعَ كُرْسِيُّهُ السَّمٰوٰتِ وَالْاَرْضَۚ وَلَا يَـُٔوْدُهٗ حِفْظُهُمَاۚ وَهُوَ الْعَلِيُّ الْعَظِيْمُ ۝٢٥٥',
                'teks_latin' => 'Allaahu laa ilaaha illaa huwal-hayyul-qayyuum, laa ta\'khudzuhuu sinatuw wa laa na\'uum, lahuu maa fis-samaawaati wa maa fil-ardh, man dzal-ladzii yasyfa\'u \'indahuu illaa bi-idznih, ya\'lamu maa baina aidiihim wa maa khalfahum, wa laa yuhiithuuna bisyai-im min \'ilmihii illaa bimaa syaa\', wasi\'a kursiyyuhus-samaawaati wal-ardh, wa laa ya-uuduhuu hifzhuhumaa, wa huwal-\'aliyyul-\'azhiim.',
                'terjemahan' => 'Allah, tidak ada tuhan selain Dia. Yang Mahahidup, Yang terus menerus mengurus (makhluk-Nya), tidak mengantuk dan tidak tidur. Milik-Nya apa yang ada di langit dan apa yang ada di bumi. Tidak ada yang dapat memberi syafaat di sisi-Nya tanpa izin-Nya. Dia mengetahui apa yang ada di hadapan mereka dan apa yang ada di belakang mereka, dan mereka tidak mengetahui sesuatu apa pun tentang ilmu-Nya melainkan apa yang Dia kehendaki. Kursi-Nya meliputi langit dan bumi. Dan Dia tidak merasa berat memelihara keduanya, dan Dia Mahatinggi, Mahabesar.',
                'jumlah_baca' => 1,
                'keterangan' => 'Ayat paling agung dalam Al-Qur\'an',
                'is_published' => true,
            ],
            [
                'urutan' => 8,
                'judul' => 'Istighfar',
                'teks_arab' => 'أَسْتَغْفِرُ اللّٰهَ الْعَظِيْمَ',
                'teks_latin' => 'Astaghfirullaahal-\'azhiim.',
                'terjemahan' => 'Aku memohon ampunan kepada Allah Yang Maha Agung.',
                'jumlah_baca' => 33,
                'keterangan' => 'Dibaca 33 kali atau 3 kali',
                'is_published' => true,
            ],
            [
                'urutan' => 9,
                'judul' => 'Kalimat Tahlil',
                'teks_arab' => 'لَا إِلٰهَ إِلَّا اللّٰهُ',
                'teks_latin' => 'Laa ilaaha illallaah.',
                'terjemahan' => 'Tiada Tuhan selain Allah.',
                'jumlah_baca' => 33,
                'keterangan' => 'Inti bacaan tahlil, dibaca 33 kali atau 100 kali',
                'is_published' => true,
            ],
            [
                'urutan' => 10,
                'judul' => 'Penutup Kalimat Tahlil & Sholawat',
                'teks_arab' => 'لَا إِلٰهَ إِلَّا اللّٰهُ مُحَمَّدٌ رَّسُوْلُ اللّٰهِ صَلَّى اللّٰهُ عَلَيْهِ وَسَلَّمَ، كَلِمَةُ حَقٍّ عَلَيْهَا نَحْيَا وَعَلَيْهَا نَمُوْتُ وَبِهَا نُبْعَثُ إِنْ شَاءَ اللّٰهُ تَعَالَى مِنَ الْآمِنِيْنَ',
                'teks_latin' => 'Laa ilaaha illallaahu Muhammadur rasuulullaahi shallallahu \'alaihi wa sallam, kalimatu haqqin \'alaihaa nahyaa wa \'alaihaa namuutu wa bihaa nub\'atsu in syaa-allaahu ta\'aalaa minal-aaminiin.',
                'terjemahan' => 'Tiada Tuhan selain Allah, Muhammad utusan Allah, semoga shalawat dan salam tercurah kepadanya. Kalimat kebenaran yang di atasnya kami hidup, kami mati, dan kelak kami dibangkitkan, insya Allah termasuk orang-orang yang aman.',
                'jumlah_baca' => 1,
                'keterangan' => 'Doa dan penutup bacaan tahlil',
                'is_published' => true,
            ],
        ];

        foreach ($items as $item) {
            TahlilItem::updateOrCreate(
                ['urutan' => $item['urutan']],
                $item
            );
        }
    }
}

