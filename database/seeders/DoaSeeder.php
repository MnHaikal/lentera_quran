<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Doa;
use App\Models\DoaCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DoaSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama' => 'Doa Harian',
                'slug' => 'doa-harian',
                'urutan' => 1,
                'doas' => [
                    [
                        'judul' => 'Doa Sebelum Tidur',
                        'teks_arab' => 'بِاسْمِكَ اللّٰهُمَّ أَحْيَا وَأَمُوْتُ',
                        'teks_latin' => 'Bismika allaahumma ahyaa wa amuutu.',
                        'terjemahan' => 'Dengan nama-Mu ya Allah, aku hidup dan aku mati.',
                        'sumber' => 'HR. Bukhari no. 6324 dan Muslim no. 2711',
                    ],
                    [
                        'judul' => 'Doa Bangun Tidur',
                        'teks_arab' => 'اَلْحَمْدُ لِلّٰهِ الَّذِيْ أَحْيَانَا بَعْدَ مَا أَمَاتَنَا وَإِلَيْهِ النُّشُوْرُ',
                        'teks_latin' => "Al-hamdu lillaahil-ladzii ahyaanaa ba'da maa amaatanaa wa ilaihin-nusyuur.",
                        'terjemahan' => 'Segala puji bagi Allah yang telah menghidupkan kami setelah mematikan kami, dan kepada-Nya lah kami dibangkitkan.',
                        'sumber' => 'HR. Bukhari no. 6312 dan Muslim no. 2711',
                    ],
                    [
                        'judul' => 'Doa Sebelum Makan',
                        'teks_arab' => 'اللّٰهُمَّ بَارِكْ لَنَا فِيْمَا رَزَقْتَنَا وَقِنَا عَذَابَ النَّارِ، بِسْمِ اللّٰهِ',
                        'teks_latin' => 'Allaahumma baarik lanaa fiimaa razaqtanaa wa qinaa \'adzaaban-naar, bismillaah.',
                        'terjemahan' => 'Ya Allah, berkahilah kami dalam rezeki yang telah Engkau berikan kepada kami dan peliharalah kami dari siksa api neraka. Dengan nama Allah.',
                        'sumber' => 'HR. Ibnu Sunni no. 457',
                    ],
                    [
                        'judul' => 'Doa Sesudah Makan',
                        'teks_arab' => 'اَلْحَمْدُ لِلّٰهِ الَّذِيْ أَطْعَمَنَا وَسَقَانَا وَجَعَلَنَا مِنَ الْمُسْلِمِيْنَ',
                        'teks_latin' => "Al-hamdu lillaahil-ladzii ath'amanaa wa saqaanaa wa ja'alanaa minal-muslimiin.",
                        'terjemahan' => 'Segala puji bagi Allah yang telah memberi makan dan minum kepada kami, serta menjadikan kami termasuk golongan orang-orang muslim.',
                        'sumber' => 'HR. Abu Dawud no. 3850 dan Tirmidzi no. 3457',
                    ],
                    [
                        'judul' => 'Doa Masuk Rumah',
                        'teks_arab' => 'بِسْمِ اللهِ وَلَجْنَا، وَبِسْمِ اللهِ خَرَجْنَا، وَعَلَى اللهِ رَبِّنَا تَوَكَّلْنَا',
                        'teks_latin' => 'Bismillaahi walajnaa, wa bismillaahi kharajnaa, wa \'alallaahi rabbinaa tawakkalnaa.',
                        'terjemahan' => 'Dengan menyebut nama Allah kami masuk, dan dengan menyebut nama Allah kami keluar, dan kepada Allah Tuhan kami, kami bertawakal.',
                        'sumber' => 'HR. Abu Dawud no. 5096',
                    ],
                    [
                        'judul' => 'Doa Keluar Rumah',
                        'teks_arab' => 'بِسْمِ اللّٰهِ تَوَكَّلْتُ عَلَى اللّٰهِ، لَا حَوْلَ وَلَا قُوَّةَ إِلَّا بِاللّٰهِ',
                        'teks_latin' => 'Bismillaahi tawakkaltu \'alallaah, laa hawla wa laa quwwata illaa billaah.',
                        'terjemahan' => 'Dengan nama Allah, aku bertawakal kepada Allah. Tiada daya dan kekuatan kecuali dengan pertolongan Allah.',
                        'sumber' => 'HR. Abu Dawud no. 5095 dan Tirmidzi no. 3426',
                    ],
                ],
            ],
            [
                'nama' => 'Doa Shalat & Sesudah Shalat',
                'slug' => 'doa-shalat',
                'urutan' => 2,
                'doas' => [
                    [
                        'judul' => 'Doa Shalat Tahajud',
                        'teks_arab' => 'اَللّٰهُمَّ لَكَ الْحَمْدُ أَنْتَ نُوْرُ السَّمٰوَاتِ وَالْأَرْضِ وَمَنْ فِيْهِنَّ',
                        'teks_latin' => 'Allaahumma lakal-hamdu anta nuurus-samaawaati wal-ardhi wa man fiihinna.',
                        'terjemahan' => 'Ya Allah, bagi-Mu segala puji, Engkaulah cahaya langit dan bumi serta apa yang ada di dalamnya.',
                        'sumber' => 'HR. Bukhari no. 1120 dan Muslim no. 769',
                    ],
                    [
                        'judul' => 'Doa Shalat Tarawih (Doa Kamilin)',
                        'teks_arab' => 'اَللّٰهُمَّ اجْعَلْنَا بِالْإِيْمَانِ كَامِلِيْنَ، وَلِلْفَرَائِضِ مُؤَدِّيْنَ',
                        'teks_latin' => 'Allaahummaj\'alnaa bil-iimaani kaamiliin, wa lil-faraa-idhi mu-addiin.',
                        'terjemahan' => 'Ya Allah, jadikanlah kami orang-orang yang sempurna imannya, dan menunaikan kewajiban-kewajiban.',
                        'sumber' => 'Doa Kamilin Masyaikh',
                    ],
                    [
                        'judul' => 'Doa Memohon Kebaikan Dunia dan Akhirat (Sapu Jagat)',
                        'teks_arab' => 'رَبَّنَآ اٰتِنَا فِى الدُّنْيَا حَسَنَةً وَّفِى الْاٰخِرَةِ حَسَنَةً وَّقِنَا عَذَابَ النَّارِ',
                        'teks_latin' => 'Rabbanaa aatinaa fid-dunyaa hasanataw wa fil-aakhirati hasanataw wa qinaa \'adzaaban-naar.',
                        'terjemahan' => 'Ya Tuhan kami, berilah kami kebaikan di dunia dan kebaikan di akhirat, dan lindungilah kami dari azab neraka.',
                        'sumber' => 'QS. Al-Baqarah: 201',
                    ],
                    [
                        'judul' => 'Doa Keteguhan Iman dan Hati',
                        'teks_arab' => 'يَا مُقَلِّبَ الْقُلُوْبِ ثَبِّتْ قَلْبِيْ عَلَى دِيْنِكَ وَعَلَى طَاعَتِكَ',
                        'teks_latin' => 'Yaa muqallibal-quluubi tsabbit qalbii \'alaa diinika wa \'alaa thaa\'atika.',
                        'terjemahan' => 'Wahai Dzat yang membolak-balikkan hati, teguhkanlah hatiku di atas agama-Mu dan ketaatan kepada-Mu.',
                        'sumber' => 'HR. Tirmidzi no. 2140 dan Ahmad 4/182',
                    ],
                    [
                        'judul' => 'Doa Ampunan untuk Diri Sendiri dan Orang Tua',
                        'teks_arab' => 'رَبِّ اغْفِرْ لِيْ وَلِوَالِدَيَّ وَارْحَمْهُمَا كَمَا رَبَّيَانِيْ صَغِيْرًا',
                        'teks_latin' => 'Rabbighfir lii wa liwaalidayya warhamhumaa kamaa rabbayaanii shaghiiraa.',
                        'terjemahan' => 'Ya Tuhanku, ampunilah aku dan kedua orang tuaku, dan sayangilah mereka berdua sebagaimana mereka telah mendidikku pada waktu kecil.',
                        'sumber' => 'QS. Al-Isra\': 24',
                    ],
                ],
            ],
            [
                'nama' => 'Doa Para Nabi',
                'slug' => 'doa-para-nabi',
                'urutan' => 3,
                'doas' => [
                    [
                        'judul' => 'Doa Nabi Yunus (Doa Ketika Menghadapi Kesulitan)',
                        'teks_arab' => 'لَآ اِلٰهَ اِلَّآ اَنْتَ سُبْحٰنَكَ اِنِّيْ كُنْتُ مِنَ الظّٰلِمِيْنَ',
                        'teks_latin' => 'Laa ilaaha illaa anta subhaanaka innii kuntu minazh-zhaalimiin.',
                        'terjemahan' => 'Tidak ada tuhan selain Engkau, Mahasuci Engkau. Sungguh, aku termasuk orang-orang yang zalim.',
                        'sumber' => 'QS. Al-Anbiya\': 87',
                    ],
                    [
                        'judul' => 'Doa Nabi Musa Memohon Kelapangan Dada',
                        'teks_arab' => 'رَبِّ اشْرَحْ لِيْ صَدْرِيْ ۝٢٥ وَيَسِّرْ لِيْٓ اَمْرِيْ ۝٢٦ وَاحْلُلْ عُقْدَةً مِّنْ لِّسَانِيْ ۝٢٧ يَفْقَهُوْا قَوْلِيْ ۝٢٨',
                        'teks_latin' => 'Rabbisy-syrah lii shadrii, wa yassir lii amrii, wahlul \'uqdatam mil lisaanii, yafqahuu qaulii.',
                        'terjemahan' => 'Ya Tuhanku, lapangkanlah dadaku, dan mudahkanlah untukku urusanku, dan lepaskanlah kekakuan dari lidahku, agar mereka mengerti perkataanku.',
                        'sumber' => 'QS. Thaha: 25-28',
                    ],
                ],
            ],
        ];

        foreach ($categories as $catData) {
            $category = DoaCategory::updateOrCreate(
                ['slug' => $catData['slug']],
                [
                    'nama' => $catData['nama'],
                    'urutan' => $catData['urutan'],
                ]
            );

            foreach ($catData['doas'] as $doaItem) {
                $slug = Str::slug($doaItem['judul']);

                Doa::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'doa_category_id' => $category->id,
                        'judul' => $doaItem['judul'],
                        'teks_arab' => $doaItem['teks_arab'],
                        'teks_latin' => $doaItem['teks_latin'],
                        'terjemahan' => $doaItem['terjemahan'],
                        'sumber' => $doaItem['sumber'],
                        'is_published' => true,
                    ]
                );
            }
        }
    }
}

