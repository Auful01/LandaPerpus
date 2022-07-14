import { Component, OnInit, SimpleChange, EventEmitter, Input, Output } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';
import { KategoriService } from '../../kategori/service/kategori.service';
import { BookService } from '../service/book.service';

@Component({
    selector: 'app-form-buku',
    templateUrl: './form-buku.component.html',
    styleUrls: ['./form-buku.component.scss']
})
export class FormBukuComponent implements OnInit {

    @Input() itemId: number;
    @Output() afterSave = new EventEmitter<boolean>();
    mode: string;
    formModel: {
        id_m_kategori_buku: number,
        judul: string,
        pengarang: string,
        penerbit: string,
        tahun_terbit: string,
        isbn: string,
        keterangan: string,
        stok: number
    };
    listKategori: any;
    listTipeDetail: any;

    constructor(
        private bookServ: BookService,
        private landaService: LandaService,
        private catService: KategoriService
    ) { }

    ngOnInit(): void {
        this.getKategori();
    }

    ngOnChanges(changes: SimpleChange) {
        this.emptyForm();
    }

    emptyForm() {
        this.mode = 'add';
        this.formModel = {
            id_m_kategori_buku: 0,
            judul: '',
            pengarang: '',
            penerbit: '',
            tahun_terbit: '',
            isbn: '',
            keterangan: '',
            stok: 0
        };

        this.listTipeDetail = [
            {
                id: 'level',
                nama: 'Level'
            },
            {
                id: 'topping',
                nama: 'Topping'
            }
        ];

        if (this.itemId > 0) {
            this.mode = 'edit';
            this.getItem(this.itemId);
        }
    }

    getKategori() {
        this.catService.getKategoris([]).subscribe((res: any) => {
            this.listKategori = res.data;
            console.log(res);

        }, err => {
            console.log(err);
        }
        );
    }

    save() {
        if (this.mode == 'add') {
            this.bookServ.createBook(this.formModel).subscribe((res: any) => {
                this.landaService.alertSuccess('Berhasil', res.message);
                this.afterSave.emit();
            }, err => {
                this.landaService.alertError('Mohon Maaf', err.error.errors);
            });
        } else {
            this.bookServ.updateBook(this.formModel).subscribe((res: any) => {
                this.landaService.alertSuccess('Berhasil', res.message);
                this.afterSave.emit();
            }, err => {
                this.landaService.alertError('Mohon Maaf', err.error.errors);
            });
        }
    }

    getItem(itemId) {
        this.bookServ.getBookById(itemId).subscribe((res: any) => {
            console.log(res);
            this.formModel = res;
        }, err => {
            console.log(err);
        });
    }


    trackByIndex(index: number): any {
        return index;
    }


    back() {
        this.afterSave.emit();
    }
}
