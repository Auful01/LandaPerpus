import { Component, OnInit, EventEmitter, Input, Output, SimpleChange } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';
import { BookService } from '../../book/service/book.service';
import { UserService } from '../../users/services/user-service.service';
import { TransactionService } from '../service/transaction.service';

@Component({
    selector: 'app-form-transaction',
    templateUrl: './form-transaction.component.html',
    styleUrls: ['./form-transaction.component.scss']
})
export class FormTransactionComponent implements OnInit {

    @Input() itemId: number;
    @Output() afterSave = new EventEmitter<boolean>();
    mode: string;
    id_buku: number;
    formModel: {
        buku: any,
        id_m_user: number,
        jumlah: number,
        status: string,
        day: number
    };
    listDay: any;
    listUser: any;
    listBuku: any;
    status: any;
    constructor(
        private transServ: TransactionService,
        private bookServ: BookService,
        private userServ: UserService,
        private landaService: LandaService
    ) { }

    ngOnInit(): void {


        this.getUser();
        this.getBuku();
        this.listDay = [
            {
                id: 1,
                nama: '1 Day'
            },
            {
                id: '2',
                nama: '2 Day'
            },
            {
                id: '3',
                nama: '3 Day'
            }
        ];

        this.status = [
            {
                id: 'pinjam',
                nama: 'Pinjam',
            },
            {
                id: 'kembali',
                nama: 'Kembali',
            }
        ]
    }

    ngOnChanges(changes: SimpleChange) {
        this.emptyForm();
    }

    emptyForm() {
        // this.mode = 'add';
        this.mode = 'add';
        this.formModel = {
            buku: [
                {
                    id_m_buku: 1,
                },
            ],
            id_m_user: 0,
            jumlah: 0,
            status: '',
            day: 0
        };

        if (this.itemId > 0) {
            this.mode = 'edit';
            this.getItem(this.itemId);
        }
    }

    save() {
        // console.log(this.formModel);
        console.log(this.itemId);
        if (this.mode == 'add') {
            console.log('tambah');

            this.transServ.createTransaction(this.formModel).subscribe((res: any) => {
                this.landaService.alertSuccess('Berhasil', res.message);
                this.afterSave.emit();
            }, err => {
                this.landaService.alertError('Mohon Maaf', err.error.errors);
            });
        } else {
            console.log('edit');
            this.transServ.updateTransaction(this.formModel).subscribe((res: any) => {
                this.landaService.alertSuccess('Berhasil', res.message);
                this.afterSave.emit();
            }, err => {
                this.landaService.alertError('Mohon Maaf', err.error.errors);
            });
        }

    }

    getItem(itemId) {
        // console.log('itemID' + itemId);
        this.transServ.getTransactionById(itemId).subscribe((res: any) => {
            console.log('res => ', res);
            this.formModel = res.data;
            // this.getBuku();
            // this.getUser();
        }, err => {
            console.log(err);
        });
    }



    getUser() {
        this.userServ.getUsers([]).subscribe((res: any) => {
            console.log(res);

            this.listUser = res.data.list;
        }, err => {
            console.log(err);
        }
        );
    }

    getBuku() {
        this.bookServ.getBooks([]).subscribe((res: any) => {
            this.listBuku = res.data;
        }, err => {
            console.log(err);
        }
        );
    }


    removeDetail(paramIndex) {
        // detail.splice(paramIndex, 1);

    }

    log(param) {
        console.log(param);
    }

    addDetail() {
        const newDet = {
            id_m_buku: this.id_buku,
        };
        console.log(newDet);
        this.formModel.buku.push(newDet);

    }

    trackByIndex(index: number): any {
        return index;
    }

    back() {
        this.afterSave.emit();
    }
}
